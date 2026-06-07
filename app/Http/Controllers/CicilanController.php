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
}