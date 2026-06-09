<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index(Rental $rental)
    {
        if (
            $rental->tenant_id != Auth::id() &&
            $rental->owner_id != Auth::id()
        ) {
            abort(403);
        }

        $rental->load([
            'item',
            'owner',
            'tenant'
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $payment = Payment::firstOrCreate(
            [
                'rental_id' => $rental->id
            ],
            [
                'payment_method' => 'midtrans',
                'amount' => $rental->total_price,
                'payment_status' => 'pending',
                'status' => 'pending'
            ]
        );

        if ($payment->payment_status == 'paid' || $rental->status == 'pesanan_masuk') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('success', 'Pembayaran telah berhasil.');
        }

        if (empty($payment->order_id) || in_array($payment->payment_status, ['expired', 'failed'])) {
            // Gunakan time() agar selalu unik
            $payment->order_id = 'RENTAL-' . $rental->id . '-' . time();
            $payment->payment_status = 'pending';
            $payment->status = 'pending';
            $payment->snap_token = null;
            $payment->save();
        }

        if (empty($payment->snap_token)) {
            try {
                $params = [
                    'transaction_details' => [
                        'order_id' => $payment->order_id,
                        'gross_amount' => (int) ceil($payment->amount),
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ],
                ];

                $payment->snap_token = Snap::getSnapToken($params);
                $payment->save();

            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return back()->with('error', 'Gagal membuat pembayaran.');
            }
        }

        return view('pages.checkout.checkout', [
            'rental' => $rental,
            'payment' => $payment,
            'snapToken' => $payment->snap_token,
            'total' => $payment->amount
        ]);
    }

    public function processPaymentSelection(Request $request, Rental $rental)
    {
        $request->validate([
            'payment_method' => 'required|in:penuh,paylater',
            'tenor'          => 'required_if:payment_method,paylater|in:2,4'
        ]);

        $payment = $rental->payment;
        $totalAmount = $payment->amount;
        
        $payment->installments()->delete();

        if ($request->payment_method === 'paylater') {
            $tenor = (int) $request->tenor;
            $amountPerTerm = $totalAmount / $tenor;

            $payment->update([
                'payment_type'     => 'paylater',
                'installment_plan' => $tenor,
                'installment_paid' => 0,
            ]);

            for ($i = 1; $i <= $tenor; $i++) {
                Installment::create([
                    'payment_id'  => $payment->id,
                    'term_number' => $i,
                    'amount'      => $amountPerTerm,
                    'due_date'    => Carbon::now()->addDays(14 * ($i - 1)),
                    'status'      => 'pending',
                ]);
            }

            $amountToPayNow = $amountPerTerm;
            // ORDER ID UNIK UNTUK TERMIN 1 (CHECKOUT)
            $orderId = 'RENTAL-' . $rental->id . '-TERM-1-' . time();
            
        } else {
            $payment->update([
                'payment_type'     => 'full',
                'installment_plan' => null,
                'installment_paid' => 0,
            ]);

            $amountToPayNow = $totalAmount;
            // ORDER ID UNIK UNTUK BAYAR PENUH
            $orderId = 'RENTAL-' . $rental->id . '-FULL-' . time();
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) ceil($amountToPayNow),
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $payment->update([
                'order_id' => $orderId,
                'snap_token' => $snapToken
            ]);

            if ($request->payment_method === 'paylater') {
                $firstInstallment = $payment->installments()->where('term_number', 1)->first();
                if ($firstInstallment) {
                    $firstInstallment->update(['snap_token' => $snapToken]);
                }
            }

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Gagal membuat token pembayaran'], 500);
        }
    }

    public function retry(Rental $rental)
    {
        DB::transaction(function () use ($rental) {
            $payment = Payment::where('rental_id', $rental->id)->firstOrFail();

            $payment->order_id = 'RENTAL-' . $rental->id . '-RETRY-' . time();
            $payment->snap_token = null;
            $payment->payment_status = 'pending';
            $payment->status = 'pending';

            if (isset($payment->transaction_id)) {
                $payment->transaction_id = null;
            }

            if (isset($payment->expired_at)) {
                $payment->expired_at = null;
            }

            $payment->save();
        });

        return redirect()->route('checkout.index', $rental);
    }
}