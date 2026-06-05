<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Membuat barang dummy milik owner.
     */
    public function run(): void
    {
        $owner = User::where('email', 'owner@rentalin.com')->first();

        $elektronik = Category::where('slug', 'elektronik-gadget')->first();
        $fashion = Category::where('slug', 'fashion-aksesoris')->first();
        $rumahTangga = Category::where('slug', 'rumah-tangga')->first();
        $hobi = Category::where('slug', 'hobi-olahraga')->first();

        if (!$owner || !$elektronik || !$fashion || !$rumahTangga || !$hobi) {
            return;
        }

        $items = [
            [
                'name' => 'Tank M103 Counter Soviet Tahun 1960 Sekali Tembak Rata',
                'description' => 'Tank sewaan untuk kebutuhan event khusus.',
                'price_per_day' => 5000000,
                'stock' => 1,
                'image' => 'tank-m103.png',
                'status' => 'available',
                'category_id' => $hobi->id,
                'kelengkapan' => [
                    'Unit tank',
                    'Kunci kendaraan',
                    'Dokumen penyewaan',
                    'Helm keselamatan',
                    'Panduan penggunaan',
                ],
            ],
            [
                'name' => 'Iphone 17 Pro Max',
                'description' => 'Smartphone premium untuk kebutuhan dokumentasi dan kerja.',
                'price_per_day' => 200000,
                'stock' => 1,
                'image' => 'iphone-17.png',
                'status' => 'available',
                'category_id' => $elektronik->id,
                'kelengkapan' => [
                    'Unit Iphone 17 Pro Max',
                    'Charger',
                    'Kabel USB-C',
                    'Dus',
                    'Case pelindung',
                    'SIM ejector',
                ],
            ],
            [
                'name' => 'Kompor Listrik Portable',
                'description' => 'Kompor listrik portable untuk kebutuhan memasak.',
                'price_per_day' => 65000,
                'stock' => 1,
                'image' => 'kompor-listrik.png',
                'status' => 'rented',
                'category_id' => $rumahTangga->id,
                'kelengkapan' => [
                    'Unit kompor listrik',
                    'Kabel power',
                    'Panci kecil',
                    'Panduan penggunaan',
                ],
            ],
            [
                'name' => 'Macbook Pro',
                'description' => 'Laptop Macbook Pro untuk kerja dan editing.',
                'price_per_day' => 500000,
                'stock' => 1,
                'image' => 'macbook-pro.png',
                'status' => 'rented',
                'category_id' => $elektronik->id,
                'kelengkapan' => [
                    'Unit Macbook Pro',
                    'Charger Macbook',
                    'Kabel charger',
                    'Tas laptop',
                    'Mouse wireless',
                ],
            ],
            [
                'name' => 'Kebaya One Set',
                'description' => 'Set kebaya warna navy untuk acara formal.',
                'price_per_day' => 200000,
                'stock' => 1,
                'image' => 'kebaya.png',
                'status' => 'available',
                'category_id' => $fashion->id,
                'kelengkapan' => [
                    'Atasan kebaya',
                    'Rok batik',
                    'Selendang',
                    'Inner',
                    'Hanger',
                ],
            ],
            [
                'name' => 'Drum',
                'description' => 'Drum untuk acara musik.',
                'price_per_day' => 150000,
                'stock' => 1,
                'image' => 'drum.png',
                'status' => 'rented',
                'category_id' => $hobi->id,
                'kelengkapan' => [
                    'Bass drum',
                    'Snare drum',
                    'Tom drum',
                    'Cymbal',
                    'Pedal drum',
                    'Stick drum',
                    'Kursi drum',
                ],
            ],
            [
                'name' => 'I Watch',
                'description' => 'Smartwatch Gen 4.',
                'price_per_day' => 200000,
                'stock' => 1,
                'image' => 'iwatch.png',
                'status' => 'rented',
                'category_id' => $elektronik->id,
                'kelengkapan' => [
                    'Unit I Watch',
                    'Strap jam',
                    'Charger magnetic',
                    'Dus',
                    'Panduan penggunaan',
                ],
            ],
            [
                'name' => 'Sepeda Gunung',
                'description' => 'Sepeda gunung untuk olahraga.',
                'price_per_day' => 70000,
                'stock' => 1,
                'image' => 'sepeda-gunung.png',
                'status' => 'available',
                'category_id' => $hobi->id,
                'kelengkapan' => [
                    'Unit sepeda gunung',
                    'Helm',
                    'Gembok sepeda',
                    'Lampu sepeda',
                    'Pompa kecil',
                ],
            ],
            [
                'name' => 'Panci Listrik',
                'description' => 'Panci listrik portable.',
                'price_per_day' => 60000,
                'stock' => 1,
                'image' => 'panci-listrik.png',
                'status' => 'rented',
                'category_id' => $rumahTangga->id,
                'kelengkapan' => [
                    'Unit panci listrik',
                    'Tutup panci',
                    'Kabel power',
                    'Sendok takar',
                    'Panduan penggunaan',
                ],
            ],
            [
                'name' => 'Coffee Maker',
                'description' => 'Mesin kopi untuk disewa.',
                'price_per_day' => 100000,
                'stock' => 1,
                'image' => 'coffee-maker.png',
                'status' => 'rented',
                'category_id' => $rumahTangga->id,
                'kelengkapan' => [
                    'Unit coffee maker',
                    'Wadah air',
                    'Filter kopi',
                    'Teko kaca',
                    'Sendok takar',
                    'Kabel power',
                ],
            ],
            [
                'name' => 'Kamera Instax',
                'description' => 'Kamera Instax untuk acara.',
                'price_per_day' => 100000,
                'stock' => 1,
                'image' => 'kamera-instax.png',
                'status' => 'available',
                'category_id' => $elektronik->id,
                'kelengkapan' => [
                    'Unit kamera Instax',
                    'Baterai',
                    'Strap kamera',
                    'Pouch kamera',
                    'Dus',
                ],
            ],
            [
                'name' => 'Raket Tenis',
                'description' => 'Raket tenis untuk olahraga.',
                'price_per_day' => 75000,
                'stock' => 1,
                'image' => 'raket-tenis.png',
                'status' => 'rented',
                'category_id' => $hobi->id,
                'kelengkapan' => [
                    'Raket tenis',
                    'Cover raket',
                    'Grip cadangan',
                    'Bola tenis',
                ],
            ],
            [
                'name' => 'Iphone 16 Pro Max',
                'description' => 'Smartphone premium untuk disewa.',
                'price_per_day' => 200000,
                'stock' => 1,
                'image' => 'iphone-16.png',
                'status' => 'rented',
                'category_id' => $elektronik->id,
                'kelengkapan' => [
                    'Unit Iphone 16 Pro Max',
                    'Charger',
                    'Kabel USB-C',
                    'Dus',
                    'Case pelindung',
                    'SIM ejector',
                ],
            ],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(
                ['name' => $item['name']],
                array_merge($item, [
                    'user_id' => $owner->id,
                ])
            );
        }
    }
}