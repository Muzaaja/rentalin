<?php

namespace App\Observers;

use App\Models\Payment;
use App\Services\NotificationService;

class PaymentObserver
{
    public function updated(Payment $payment): void
    {
        if (!$payment->wasChanged('payment_status')) {
            return;
        }

        switch ($payment->payment_status) {

            case 'pending':

                NotificationService::send(

                    $payment->user_id,

                    "Menunggu Pembayaran",

                    "Silakan selesaikan pembayaran",

                    "payment",

                    "pending",

                    "/payments/".$payment->id,

                    null,

                    $payment->id

                );

            break;



            case 'paid':

                NotificationService::send(

                    $payment->user_id,

                    "Pembayaran Berhasil",

                    "Pembayaran berhasil dilakukan",

                    "payment",

                    "berhasil",

                    "/payments/".$payment->id,

                    null,

                    $payment->id

                );

                NotificationService::send(

                    $payment->owner_id,

                    "Pembayaran Diterima",

                    "Pembayaran berhasil diterima",

                    "payment",

                    "berhasil",

                    "/payments/".$payment->id,

                    null,

                    $payment->id

                );

            break;



            case 'expired':

                NotificationService::send(

                    $payment->user_id,

                    "Pembayaran Kadaluarsa",

                    "Batas waktu pembayaran telah habis",

                    "payment",

                    "expired",

                    "/payments/".$payment->id,

                    null,

                    $payment->id

                );

            break;



            case 'failed':

                NotificationService::send(

                    $payment->user_id,

                    "Pembayaran Gagal",

                    "Pembayaran gagal dilakukan",

                    "payment",

                    "gagal",

                    "/payments/".$payment->id,

                    null,

                    $payment->id

                );

            break;

        }
    }
}