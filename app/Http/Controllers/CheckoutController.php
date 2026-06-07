<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        Config::$isProduction = config('midtrans.is_production');
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

        if (
            $payment->payment_status == 'paid'
            || $rental->status == 'pesanan_masuk'
        ) {

            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with(
                    'success',
                    'Pembayaran telah berhasil.'
                );
        }

        if (
            empty($payment->order_id)
            || in_array(
                $payment->payment_status,
                ['expired', 'failed']
            )
        ) {

            $payment->order_id =
                'RENTAL-' .
                $rental->id .
                '-' .
                time();

            $payment->payment_status = 'pending';
            $payment->status = 'pending';
            $payment->snap_token = null;

            $payment->save();
        }

        if (
            empty($payment->snap_token)
        ) {

            try {

                $params = [

                    'transaction_details' => [

                        'order_id' => $payment->order_id,

                        'gross_amount' => (int) $payment->amount,

                    ],

                    'customer_details' => [

                        'first_name' => Auth::user()->name,

                        'email' => Auth::user()->email,

                    ],

                ];

                $payment->snap_token =
                    Snap::getSnapToken($params);

                $payment->save();

            } catch (\Exception $e) {

                Log::error($e->getMessage());

                return back()->with(
                    'error',
                    'Gagal membuat pembayaran.'
                );
            }
        }

        return view(
            'pages.checkout.checkout',
            [
                'rental' => $rental,
                'payment' => $payment,
                'snapToken' => $payment->snap_token
            ]
        );
    }

    public function retry(Rental $rental)
    {
        DB::transaction(function () use ($rental) {

            $payment = Payment::where(
                'rental_id',
                $rental->id
            )->firstOrFail();

            $payment->order_id =
                'RENTAL-' .
                $rental->id .
                '-' .
                time();

            $payment->snap_token = null;

            $payment->payment_status = 'pending';

            $payment->status = 'pending';

            if (
                isset($payment->transaction_id)
            ) {

                $payment->transaction_id = null;
            }

            if (
                isset($payment->expired_at)
            ) {

                $payment->expired_at = null;
            }

            $payment->save();
        });

        return redirect()->route(
            'checkout.index',
            $rental
        );
    }
}