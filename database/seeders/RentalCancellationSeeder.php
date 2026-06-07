<?php

namespace Database\Seeders;

use App\Models\Rental;
use App\Models\RentalCancellation;
use Illuminate\Database\Seeder;

class RentalCancellationSeeder extends Seeder
{
    public function run(): void
    {
        $cancellations = [
            'TRX-20260828-0188' => [
                'cancelled_by' => 'penyewa',
                'reason' => 'Jadwal sewa berubah',
                'note' => 'Penyewa membatalkan karena barang sudah tidak dibutuhkan pada tanggal tersebut.',
                'refund_amount' => 0,
                'refund_status' => 'tidak_ada_refund',
            ],
            'TRX-20260901-0048' => [
                'cancelled_by' => 'penyewa',
                'reason' => 'Salah memilih barang',
                'note' => 'Penyewa ingin mengganti barang dengan produk lain.',
                'refund_amount' => 0,
                'refund_status' => 'tidak_ada_refund',
            ],
        ];

        foreach ($cancellations as $rentalCode => $data) {
            $rental = Rental::where('rental_code', $rentalCode)->first();

            if (!$rental) {
                continue;
            }

            RentalCancellation::updateOrCreate(
                ['rental_id' => $rental->id],
                $data
            );
        }
    }
}