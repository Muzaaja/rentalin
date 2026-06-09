<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Installment;
use Carbon\Carbon;

class CicilanController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'belum_lunas');
        $user = Auth::user();

        $query = Payment::where('payment_type', 'paylater')
            ->whereHas('rental', function($q) use ($user) {
                $q->where('tenant_id', $user->id);
            });

        // Filter berdasarkan keberadaan cicilan aktif
        if ($tab === 'selesai') {
            // Cicilan selesai = tidak ada installment pending/overdue
            $payments = $query->whereDoesntHave('installments', function($q) {
                $q->whereIn('status', ['pending', 'overdue']);
            })->get();
        } else {
            // Belum lunas = HARUS ada installment pending/overdue
            $payments = $query->whereHas('installments', function($q) {
                $q->whereIn('status', ['pending', 'overdue']);
            })
            ->with(['rental.item', 'rental.owner', 'installments' => function($q) {
                $q->orderBy('term_number', 'asc');
            }])
            ->get();
        }

        // Hitung ringkasan tagihan berdasarkan installment aktif saja
        $totalTagihan = Installment::whereIn('status', ['pending', 'overdue'])
            ->whereHas('payment.rental', function($q) use ($user) {
                $q->where('tenant_id', $user->id);
            })
            ->sum('amount');

        $jatuhTempoTerdekat = Installment::whereIn('status', ['pending', 'overdue'])
            ->whereHas('payment.rental', function($q) use ($user) {
                $q->where('tenant_id', $user->id);
            })
            ->orderBy('due_date', 'asc')
            ->value('due_date');

        $summary = [
            'total_tagihan' => $totalTagihan,
            'jatuh_tempo_terdekat' => $jatuhTempoTerdekat ? \Carbon\Carbon::parse($jatuhTempoTerdekat)->format('d M Y') : '-',
        ];

        return view('pages.profile.cicilan.index', compact('user', 'tab', 'payments', 'summary'));
    }

    // FUNGSI SHOW YANG BARU DITAMBAHKAN
    public function show($id)
    {
        $user = Auth::user();

        $payment = Payment::where('id', $id)
            ->where('payment_type', 'paylater')
            ->whereHas('rental', function($q) use ($user) {
                $q->where('tenant_id', $user->id);
            })
            ->with(['rental.item', 'rental.owner', 'installments' => function($q) {
                $q->orderBy('term_number', 'asc');
            }])
            ->firstOrFail();

        // Cari cicilan aktif yang belum dibayar (pending atau overdue)
        $activeInstallment = $payment->installments->whereIn('status', ['pending', 'overdue'])->first();
        $snapToken = null;

        // Jika ada cicilan aktif, buatkan Snap Token spesifik untuk termin ini
        if ($activeInstallment) {
            if (empty($activeInstallment->snap_token)) {
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                // Memastikan order_id unik di setiap termin dengan time()
                $orderId = 'RENTAL-' . $payment->rental->id . '-TERM-' . $activeInstallment->term_number . '-' . time();

                $params = [
                    'transaction_details' => [
                        'order_id'     => $orderId,
                        'gross_amount' => ceil($activeInstallment->amount),
                    ],
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email'      => $user->email,
                    ],
                ];

                try {
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    $activeInstallment->update(['snap_token' => $snapToken]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Midtrans Installment Error: ' . $e->getMessage());
                }
            } else {
                $snapToken = $activeInstallment->snap_token;
            }
        }

        return view('pages.profile.cicilan.show', compact('user', 'payment', 'activeInstallment', 'snapToken'));
    }
}