<?php

namespace App\Observers;

use App\Models\Rental;
use App\Services\NotificationService;

class RentalObserver
{
    public function updated(Rental $rental): void
    {
        if (!$rental->wasChanged('status')) {
            return;
        }

        switch ($rental->status) {

            case 'requested':

                NotificationService::send(

                    $rental->owner_id,

                    "Permintaan Sewa Baru",

                    $rental->user->name .
                    " mengajukan permintaan sewa " .
                    $rental->product->name,

                    "request",

                    "baru",

                    "/owner/rentals/".$rental->id,

                    $rental->id

                );

            break;


            case 'approved':

                NotificationService::send(

                    $rental->user_id,

                    "Permintaan Disetujui",

                    "Permintaan sewa Anda telah disetujui",

                    "approve",

                    "disetujui",

                    "/rentals/".$rental->id,

                    $rental->id

                );

            break;


            case 'rejected':

                NotificationService::send(

                    $rental->user_id,

                    "Permintaan Ditolak",

                    "Permintaan sewa Anda ditolak",

                    "reject",

                    "ditolak",

                    "/rentals/".$rental->id,

                    $rental->id

                );

            break;


            case 'active':

                NotificationService::send(

                    $rental->user_id,

                    "Barang Diserahkan",

                    "Barang telah diserahkan kepada Anda",

                    "active",

                    "aktif",

                    "/rentals/".$rental->id,

                    $rental->id

                );

            break;


            case 'returned':

                NotificationService::send(

                    $rental->owner_id,

                    "Barang Dikembalikan",

                    "Barang telah dikembalikan oleh penyewa",

                    "return",

                    "selesai",

                    "/owner/rentals/".$rental->id,

                    $rental->id

                );

            break;


            case 'completed':

                NotificationService::send(

                    $rental->user_id,

                    "Transaksi Selesai",

                    "Transaksi penyewaan telah selesai",

                    "completed",

                    "selesai",

                    "/rentals/".$rental->id,

                    $rental->id

                );

            break;

        }
    }
}