<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\RentalExtension;
use App\Models\Installment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $signature = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signature !== $request->signature_key) {
            return response()->json([
                'message' => 'Invalid signature',
            ], 403);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        /*
        |--------------------------------------------------------------------------
        | Callback Pembayaran Perpanjangan Sewa
        |--------------------------------------------------------------------------
        | Format order_id perpanjangan: EXT-....
        */

        if (str_starts_with($request->order_id, 'EXT-')) {
            $extension = RentalExtension::where('order_id', $request->order_id)->first();

            if (!$extension) {
                return response()->json([
                    'message' => 'Data perpanjangan tidak ditemukan',
                ], 404);
            }

            if (
                $transactionStatus === 'settlement' ||
                ($transactionStatus === 'capture' && $fraudStatus === 'accept')
            ) {
                DB::transaction(function () use ($extension) {
                    if ($extension->payment_status !== 'paid' && $extension->payment_status !== 'paylater_aktif') {
                        $extension->update([
                            'payment_status' => $extension->payment_type === 'paylater'
                                ? 'paylater_aktif'
                                : 'paid',
                        ]);

                        $rental = Rental::find($extension->rental_id);

                        if ($rental) {
                            $rental->update([
                                'end_date' => $extension->new_end_date,
                                'total_price' => (float) $rental->total_price + (float) $extension->extension_price,
                            ]);

                            if (class_exists(NotificationService::class)) {
                                NotificationService::send(
                                    $rental->tenant_id,
                                    'Perpanjangan Berhasil',
                                    'Pembayaran perpanjangan sewa berhasil diproses.',
                                    'extension',
                                    'paid',
                                    '/riwayatTransaksiPenyewa',
                                    $rental->id,
                                    $extension->id
                                );

                                NotificationService::send(
                                    $rental->owner_id,
                                    'Perpanjangan Sewa',
                                    'Penyewa berhasil memperpanjang masa sewa.',
                                    'extension',
                                    'paid',
                                    '/riwayatTransaksiPemilik',
                                    $rental->id,
                                    $extension->id
                                );
                            }
                        }
                    }
                });
            }

            if ($transactionStatus === 'pending') {
                $extension->update([
                    'payment_status' => 'pending',
                ]);
            }

            if (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
                $extension->update([
                    'payment_status' => 'failed',
                ]);
            }

            return response()->json([
                'message' => 'Callback perpanjangan berhasil diproses',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Callback Pembayaran Rental Utama
        |--------------------------------------------------------------------------
        | Prioritas cari payment lewat order_id.
        | Kalau tidak ketemu, ambil rental_id dari format RENTAL-{id}-...
        */

        $payment = Payment::where('order_id', $request->order_id)->first();

        if (!$payment) {
            preg_match('/RENTAL-(\d+)/', $request->order_id, $rentalMatches);

            if (!isset($rentalMatches[1])) {
                return response()->json([
                    'message' => 'Format order_id tidak dikenali',
                ], 422);
            }

            $payment = Payment::where('rental_id', $rentalMatches[1])->first();
        }

        if (!$payment) {
            return response()->json([
                'message' => 'Data payment tidak ditemukan',
            ], 404);
        }

        $rental = Rental::find($payment->rental_id);

        if (!$rental) {
            return response()->json([
                'message' => 'Data rental tidak ditemukan',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Status Berhasil
        |--------------------------------------------------------------------------
        | Setelah pembayaran berhasil:
        | - payment_status/status = paid atau partially_paid
        | - rental.status = pesanan_masuk
        */

        if (
            $transactionStatus === 'settlement' ||
            ($transactionStatus === 'capture' && $fraudStatus === 'accept')
        ) {
            DB::transaction(function () use ($payment, $rental, $request) {
                if ($payment->payment_type === 'paylater') {
                    preg_match('/-TERM-(\d+)-/', $request->order_id, $termMatches);

                    $termNumber = isset($termMatches[1])
                        ? (int) $termMatches[1]
                        : 1;

                    $installment = Installment::where('payment_id', $payment->id)
                        ->where('term_number', $termNumber)
                        ->first();

                    if ($installment && $installment->status !== 'paid') {
                        $installment->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        $payment->increment('installment_paid');
                        $payment->refresh();
                    }

                    if ($payment->installment_paid >= $payment->installment_plan) {
                        $payment->update([
                            'payment_status' => 'paid',
                            'status' => 'paid',
                        ]);
                    } else {
                        $payment->update([
                            'payment_status' => 'partially_paid',
                            'status' => 'pending',
                        ]);
                    }

                    /*
                    Setelah cicilan pertama berhasil, pesanan masuk ke pemilik.
                    Database pakai pesanan_masuk.
                    Tampilan penyewa akan menampilkan Diproses.
                    Tampilan pemilik akan menampilkan Pesanan Masuk.
                    */
                    if ($rental->status === 'menunggu_pembayaran') {
                        $rental->update([
                            'status' => 'pesanan_masuk',
                        ]);
                    }
                } else {
                    if ($payment->payment_status !== 'paid') {
                        $payment->update([
                            'payment_status' => 'paid',
                            'status' => 'paid',
                        ]);
                    }

                    $rental->update([
                        'status' => 'pesanan_masuk',
                    ]);
                }

                if (class_exists(NotificationService::class)) {
                    NotificationService::send(
                        $rental->owner_id,
                        'Pembayaran Berhasil',
                        'Pembayaran penyewaan telah diterima.',
                        'payment',
                        'paid',
                        '/riwayatTransaksiPemilik',
                        $rental->id,
                        $payment->id
                    );

                    NotificationService::send(
                        $rental->tenant_id,
                        'Pembayaran Berhasil',
                        'Pembayaran Anda berhasil.',
                        'payment',
                        'paid',
                        '/riwayatTransaksiPenyewa',
                        $rental->id,
                        $payment->id
                    );
                }
            });

            return response()->json([
                'message' => 'Callback pembayaran berhasil diproses',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Status Pending
        |--------------------------------------------------------------------------
        */

        if ($transactionStatus === 'pending') {
            $payment->update([
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            if (class_exists(NotificationService::class)) {
                NotificationService::send(
                    $rental->tenant_id,
                    'Menunggu Pembayaran',
                    'Silakan selesaikan pembayaran Anda.',
                    'payment',
                    'pending',
                    '/checkout/' . $rental->id,
                    $rental->id,
                    $payment->id
                );
            }

            return response()->json([
                'message' => 'Callback pending berhasil diproses',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Status Gagal / Kadaluarsa
        |--------------------------------------------------------------------------
        */

        if (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            $payment->update([
                'payment_status' => $transactionStatus === 'expire' ? 'expired' : 'failed',
                'status' => 'failed',
            ]);

            if (class_exists(NotificationService::class)) {
                NotificationService::send(
                    $rental->tenant_id,
                    $transactionStatus === 'expire' ? 'Pembayaran Kadaluarsa' : 'Pembayaran Gagal',
                    $transactionStatus === 'expire'
                        ? 'Batas waktu pembayaran telah habis.'
                        : 'Pembayaran gagal diproses.',
                    'payment',
                    $transactionStatus === 'expire' ? 'expired' : 'failed',
                    '/checkout/' . $rental->id,
                    $rental->id,
                    $payment->id
                );
            }

            return response()->json([
                'message' => 'Callback gagal/kadaluarsa berhasil diproses',
            ]);
        }

        return response()->json([
            'message' => 'Callback diterima, tidak ada perubahan status',
        ]);
    }

    public function demoSuccess(Rental $rental)
    {
        DB::transaction(function () use ($rental) {
            $payment = Payment::where('rental_id', $rental->id)->firstOrFail();

            $payment->update([
                'payment_status' => 'paid',
                'status' => 'paid',
            ]);

            $rental->update([
                'status' => 'pesanan_masuk',
            ]);

            if (class_exists(NotificationService::class)) {
                NotificationService::send(
                    $rental->owner_id,
                    'Pembayaran Berhasil',
                    'Pembayaran penyewaan berhasil.',
                    'payment',
                    'paid',
                    '/riwayatTransaksiPemilik',
                    $rental->id,
                    $payment->id
                );

                NotificationService::send(
                    $rental->tenant_id,
                    'Pembayaran Berhasil',
                    'Pembayaran Anda berhasil.',
                    'payment',
                    'paid',
                    '/riwayatTransaksiPenyewa',
                    $rental->id,
                    $payment->id
                );
            }
        });

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success_title', 'Pembayaran Berhasil')
            ->with('success_message', 'Pembayaran berhasil. Pesanan Anda sedang diproses oleh pemilik.');
    }
}