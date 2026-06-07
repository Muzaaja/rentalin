<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Services\NotificationService;
=======
use Illuminate\Http\Request;
>>>>>>> f2d900839fd856b12316720e941673f067de96c5
use App\Models\Payment;
use App\Models\Installment;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // Verifikasi keaslian notifikasi dari Midtrans
        if ($hashed == $request->signature_key) {
            
            // Jika pembayaran berhasil (settlement/capture)
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                // 1. Ekstrak ID Rental dari order_id (Format: RENTAL-{id}-TERM-{term}-{time})
                preg_match('/RENTAL-(\d+)/', $request->order_id, $rentalMatches);
                if (!isset($rentalMatches[1])) {
                    return response()->json(['message' => 'Format order_id tidak dikenali']);
                }
                
                $rentalId = $rentalMatches[1];
                $payment = Payment::where('rental_id', $rentalId)->first();

<<<<<<< HEAD
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
=======
                if (!$payment) {
                    return response()->json(['message' => 'Data payment tidak ditemukan']);
>>>>>>> f2d900839fd856b12316720e941673f067de96c5
                }

                // 2. Jika transaksi ini adalah Cicilan (Paylater)
                if ($payment->payment_type == 'paylater') {
                    
                    // Ekstrak termin ke berapa yang sedang dibayar
                    preg_match('/-TERM-(\d+)-/', $request->order_id, $termMatches);
                    $termNumber = isset($termMatches[1]) ? (int) $termMatches[1] : 1;

                    // Cari baris cicilan yang sesuai
                    $installment = Installment::where('payment_id', $payment->id)
                        ->where('term_number', $termNumber)
                        ->first();

                    if ($installment && $installment->status !== 'paid') {
                        
                        // Tandai cicilan ini lunas
                        $installment->update([
                            'status' => 'paid',
                            'paid_at' => now()
                        ]);

                        // Tambahkan jumlah cicilan yang sudah dibayar pada tabel payment utama
                        $payment->increment('installment_paid');

                        // Jika ini pembayaran pertama (DP), ubah status rental menjadi diproses
                        if ($termNumber == 1) {
                            $payment->rental->update(['status' => 'diproses']);
                        }

                        // Cek apakah semua cicilan sudah lunas secara keseluruhan
                        if ($payment->installment_paid >= $payment->installment_plan) {
                            $payment->update([
                                'payment_status' => 'paid',
                                'status' => 'paid'
                            ]);
                        } else {
                            $payment->update([
                                'payment_status' => 'partially_paid',
                                'status' => 'pending' // Status transaksi utama masih berjalan
                            ]);
                        }
                    }

                } else {
                    // 3. Jika ini adalah transaksi Bayar Penuh (Full)
                    if ($payment->payment_status !== 'paid') {
                        $payment->update([
                            'payment_status' => 'paid',
                            'status' => 'paid'
                        ]);
                        $payment->rental->update(['status' => 'diproses']);
                    }
                }
            }
        }

        return response()->json(['message' => 'Callback berhasil diproses']);
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