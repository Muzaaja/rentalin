<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function callback()
    {
        try {

            $notification = new Notification();

            Log::info("Midtrans Callback", (array)$notification);

            $serverKey = config('midtrans.server_key');

            $signature = hash(
                'sha512',
                $notification->order_id .
                $notification->status_code .
                $notification->gross_amount .
                $serverKey
            );

            if (
                $signature !=
                $notification->signature_key
            ) {

                return response()->json([
                    'message' => 'Invalid Signature'
                ], 403);
            }

            $payment = Payment::where(
                'order_id',
                $notification->order_id
            )->first();

            if (!$payment) {

                return response()->json([
                    'message' => 'Payment Not Found'
                ], 404);
            }

            DB::transaction(function () use (
                $payment,
                $notification
            ) {

                $rental = Rental::find(
                    $payment->rental_id
                );

                switch (
                    $notification->transaction_status
                ) {

                    case 'capture':

                        if (
                            $notification->fraud_status == 'accept'
                        ) {

                            $payment->payment_status = 'paid';
                            $payment->status = 'paid';

                            if ($rental) {

                                $rental->status =
                                    'pesanan_masuk';

                                $rental->save();
                            }
                        }

                        break;

                    case 'settlement':

                        $payment->payment_status =
                            'paid';

                        $payment->status =
                            'paid';

                        if ($rental) {

                            $rental->status =
                                'pesanan_masuk';

                            $rental->save();

                            NotificationService::send(

    $rental->owner_id,

    "Pembayaran Berhasil",

    "Pembayaran penyewaan telah diterima.",

    "payment",

    "berhasil",

    "/riwayat-transaksi/pemilik",

    $rental->id,

    $payment->id

);

NotificationService::send(

    $rental->tenant_id,

    "Pembayaran Berhasil",

    "Pembayaran Anda berhasil.",

    "payment",

    "berhasil",

    "/riwayat-transaksi/penyewa",

    $rental->id,

    $payment->id

);
                        }

                        break;

                    case 'pending':
                        NotificationService::send(

    $rental->tenant_id,

    "Menunggu Pembayaran",

    "Silakan selesaikan pembayaran Anda.",

    "payment",

    "pending",

    "/checkout/".$rental->id,

    $rental->id,

    $payment->id

);

                        $payment->payment_status =
                            'pending';

                        $payment->status =
                            'pending';

                        break;

                    case 'expire':

NotificationService::send(

    $rental->tenant_id,

    "Pembayaran Kadaluarsa",

    "Batas waktu pembayaran telah habis.",

    "payment",

    "expired",

    "/checkout/".$rental->id,

    $rental->id,

    $payment->id

);
                        $payment->payment_status =
                            'expired';

                        $payment->status =
                            'expired';

                        break;

                    case 'cancel':

                    case 'deny':

                        NotificationService::send(

    $rental->tenant_id,

    "Pembayaran Gagal",

    "Pembayaran gagal diproses.",

    "payment",

    "failed",

    "/checkout/".$rental->id,

    $rental->id,

    $payment->id

);

                        $payment->payment_status =
                            'failed';

                        $payment->status =
                            'failed';

                        break;
                }

                $payment->save();
            });

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function demoSuccess(Rental $rental)
    {
        DB::transaction(function () use ($rental) {

            $payment = Payment::where(
                'rental_id',
                $rental->id
            )->firstOrFail();

            $payment->payment_status = 'paid';
            $payment->status = 'paid';

            $payment->save();

            $rental->status =
                'pesanan_masuk';

            $rental->save();

            NotificationService::send(

    $rental->owner_id,

    "Pembayaran Berhasil",

    "Pembayaran penyewaan berhasil.",

    "payment",

    "paid",

    "/riwayat-transaksi/pemilik",

    $rental->id,

    $payment->id

);

NotificationService::send(

    $rental->tenant_id,

    "Pembayaran Berhasil",

    "Pembayaran Anda berhasil.",

    "payment",

    "paid",

    "/riwayat-transaksi/penyewa",

    $rental->id,

    $payment->id

);
        });

        return redirect()
            ->route(
                'riwayat.transaksi.penyewa'
            )
            ->with(
                'success',
                'Pembayaran berhasil.'
            );
    }
}