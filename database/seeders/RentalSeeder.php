<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\Rental;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    /**
     * Membuat transaksi rental dummy.
     * Data ini sudah nyambung ke users dan items.
     */
    public function run(): void
    {
        $owner = User::where('email', 'owner@rentalin.com')->first();
        $tenant = User::where('email', 'tenant@rentalin.com')->first();
        $tenant2 = User::where('email', 'tariq@rentalin.com')->first();

        $rentals = [
            [
                'rental_code' => 'TRX-20260901-0042',
                'item_name' => 'Tank M103 Counter Soviet Tahun 1960 Sekali Tembak Rata',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-09-05',
                'end_date' => '2026-09-08',
                'total_price' => 5000000,
                'status' => 'diproses',
            ],
            [
                'rental_code' => 'TRX-20260828-0187',
                'item_name' => 'Iphone 17 Pro Max',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-08-28',
                'end_date' => '2026-08-30',
                'total_price' => 400000,
                'status' => 'selesai',
            ],
            [
                'rental_code' => 'TRX-20260901-0043',
                'item_name' => 'Kompor Listrik Portable',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-09-08',
                'end_date' => '2026-09-12',
                'total_price' => 65000,
                'status' => 'disewa',
            ],
            [
                'rental_code' => 'TRX-20260901-0044',
                'item_name' => 'Macbook Pro',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-05-10',
                'end_date' => '2026-05-13',
                'total_price' => 500000,
                'status' => 'pengembalian',
            ],
            [
                'rental_code' => 'TRX-20260828-0188',
                'item_name' => 'Kebaya One Set',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-05-08',
                'end_date' => '2026-05-10',
                'total_price' => 200000,
                'status' => 'dibatalkan',
            ],
            [
                'rental_code' => 'TRX-20260901-0045',
                'item_name' => 'Drum',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-05-07',
                'end_date' => '2026-05-10',
                'total_price' => 150000,
                'status' => 'belum_dikembalikan',
            ],
            [
                'rental_code' => 'TRX-20260901-0046',
                'item_name' => 'I Watch',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-05-08',
                'end_date' => '2026-05-12',
                'total_price' => 200000,
                'status' => 'kerusakan',
                'damage_description' => 'Terdapat kerusakan pada bagian body barang setelah dikembalikan.',
                'damage_fee' => 70000,
            ],
            [
                'rental_code' => 'TRX-20260828-0189',
                'item_name' => 'Sepeda Gunung',
                'tenant_id' => $tenant2->id,
                'start_date' => '2026-08-28',
                'end_date' => '2026-08-30',
                'total_price' => 70000,
                'status' => 'pesanan_masuk',
            ],
            [
                'rental_code' => 'TRX-20260828-0190',
                'item_name' => 'Panci Listrik',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-08-28',
                'end_date' => '2026-08-30',
                'total_price' => 60000,
                'status' => 'disewa',
            ],
            [
                'rental_code' => 'TRX-20260901-0047',
                'item_name' => 'Coffee Maker',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-05-09',
                'end_date' => '2026-05-13',
                'total_price' => 100000,
                'status' => 'pengembalian',
            ],
            [
                'rental_code' => 'TRX-20260901-0048',
                'item_name' => 'Kamera Instax',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-05-09',
                'end_date' => '2026-05-13',
                'total_price' => 100000,
                'status' => 'dibatalkan',
            ],
            [
                'rental_code' => 'TRX-20260901-0049',
                'item_name' => 'Raket Tenis',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-05-07',
                'end_date' => '2026-05-10',
                'total_price' => 75000,
                'status' => 'belum_dikembalikan',
            ],
            [
                'rental_code' => 'TRX-20260901-0050',
                'item_name' => 'Iphone 16 Pro Max',
                'tenant_id' => $tenant->id,
                'start_date' => '2026-05-08',
                'end_date' => '2026-05-12',
                'total_price' => 200000,
                'status' => 'kerusakan',
                'damage_description' => 'Barang tidak lengkap dan terdapat kerusakan pada bagian luar.',
                'damage_fee' => 80000,
            ],
        ];

        foreach ($rentals as $rentalData) {
            $item = Item::where('name', $rentalData['item_name'])->first();

            Rental::updateOrCreate(
                ['rental_code' => $rentalData['rental_code']],
                [
                    'item_id' => $item->id,
                    'owner_id' => $owner->id,
                    'tenant_id' => $rentalData['tenant_id'],
                    'start_date' => $rentalData['start_date'],
                    'end_date' => $rentalData['end_date'],
                    'total_price' => $rentalData['total_price'],
                    'status' => $rentalData['status'],
                    'damage_description' => $rentalData['damage_description'] ?? null,
                    'damage_fee' => $rentalData['damage_fee'] ?? null,
                ]
            );
        }
    }
}