<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::where('email', 'owner@rentalin.com')->first();

        if (!$owner) {
            $this->command->warn('User owner@rentalin.com tidak ditemukan. Skip ItemSeeder.');
            return;
        }

        $elektronik  = Category::where('slug', 'elektronik-gadget')->first();
        $fashion     = Category::where('slug', 'fashion-aksesoris')->first();
        $pesta       = Category::where('slug', 'pesta-event')->first();
        $rumahTangga = Category::where('slug', 'rumah-tangga')->first();
        $hobi        = Category::where('slug', 'hobi-olahraga')->first();

        if (!$elektronik || !$fashion || !$pesta || !$rumahTangga || !$hobi) {
            $this->command->warn('CategorySeeder belum dijalankan. ItemSeeder dibatalkan.');
            return;
        }

        // Gambar yang tersedia di storage/app/public/items/
        // (hasil copy dari public/assets/img/produk/*.png)
        $img = [
            'iphone17'  => ['items/Rectangle-19@2x.png'],
            'dji'       => ['items/Rectangle-191@2x.png'],
            'sepeda'    => ['items/Rectangle-192@2x.png'],
            'ipad'      => ['items/Rectangle-193@2x.png'],
            'airfryer'  => ['items/Rectangle-194@2x.png'],
            'kopi'      => ['items/Rectangle-195@2x.png'],
            'raket'     => ['items/Rectangle-196@2x.png'],
            'kompor'    => ['items/Rectangle-197@2x.png'],
            'iphone16'  => ['items/Rectangle-198@2x.png'],
            'gitar'     => ['items/Rectangle-199@2x.png'],
            'kebaya'    => ['items/Rectangle-1910@2x.png'],
            'ht'        => ['items/Rectangle-1911@2x.png'],
            'sound'     => ['items/Rectangle-1912@2x.png'],
            'applewatch'=> ['items/Rectangle-1913@2x.png'],
            'tenda'     => ['items/Rectangle-1914@2x.png'],
        ];

        $items = [

            // ── Elektronik & Gadget ──
            [
                'name'        => 'iPhone 17 Pro Max',
                'description' => 'Smartphone premium Apple terbaru untuk dokumentasi, konten kreator, dan kerja profesional.',
                'price_per_day' => 100000,
                'category_id' => $elektronik->id,
                'kecamatan'   => 'Cibiru',
                'image'       => $img['iphone17'],
                'kelengkapan' => ['Unit iPhone 17 Pro Max', 'Charger 30W', 'Kabel USB-C', 'Dus original', 'Case pelindung'],
            ],
            [
                'name'        => 'iPhone 16 Pro Max 1TB',
                'description' => 'iPhone 16 Pro Max kapasitas besar untuk videografer profesional.',
                'price_per_day' => 115000,
                'category_id' => $elektronik->id,
                'kecamatan'   => 'Cileunyi',
                'image'       => $img['iphone16'],
                'kelengkapan' => ['Unit iPhone 16 Pro Max', 'Charger', 'Kabel USB-C', 'Dus'],
            ],
            [
                'name'        => 'iPad Gen 10 Blue',
                'description' => 'Tablet Apple generasi terbaru cocok untuk presentasi dan desain.',
                'price_per_day' => 50000,
                'category_id' => $elektronik->id,
                'kecamatan'   => 'Cibiru',
                'image'       => $img['ipad'],
                'kelengkapan' => ['Unit iPad', 'Charger', 'Kabel USB-C', 'Case', 'Apple Pencil'],
            ],
            [
                'name'        => 'DJI Osmo Pocket 3',
                'description' => 'Kamera gimbal pocket stabilizer terbaik untuk video cinematic.',
                'price_per_day' => 70000,
                'category_id' => $elektronik->id,
                'kecamatan'   => 'Majalaya',
                'image'       => $img['dji'],
                'kelengkapan' => ['Unit DJI Osmo Pocket 3', 'Kabel data', 'Case', 'Memory card 64GB'],
            ],
            [
                'name'        => 'Apple Watch Series 9',
                'description' => 'Smartwatch Apple terbaru dengan fitur kesehatan lengkap.',
                'price_per_day' => 60000,
                'category_id' => $elektronik->id,
                'kecamatan'   => 'Cileunyi',
                'image'       => $img['applewatch'],
                'kelengkapan' => ['Unit Apple Watch', 'Strap sport', 'Charger magnetic', 'Dus'],
            ],
            [
                'name'        => 'Kamera Instax Mini 12',
                'description' => 'Kamera polaroid instan cocok untuk acara ulang tahun dan gathering.',
                'price_per_day' => 40000,
                'category_id' => $elektronik->id,
                'kecamatan'   => 'Bandung',
                'image'       => $img['dji'],
                'kelengkapan' => ['Unit kamera Instax', 'Baterai AA', 'Strap kamera', 'Film 1 pack'],
            ],
            [
                'name'        => 'HT Motorola Merk Bagus',
                'description' => 'Handy talkie untuk hiking, event, dan koordinasi tim.',
                'price_per_day' => 25000,
                'category_id' => $elektronik->id,
                'kecamatan'   => 'Cicalengka',
                'image'       => $img['ht'],
                'kelengkapan' => ['Unit HT', 'Baterai', 'Charger', 'Antena', 'Klip belt'],
            ],
            [
                'name'        => 'Sound System Lengkap',
                'description' => 'Paket sound system untuk pesta, seminar, dan acara outdoor.',
                'price_per_day' => 500000,
                'category_id' => $elektronik->id,
                'kecamatan'   => 'Majalaya',
                'image'       => $img['sound'],
                'kelengkapan' => ['Speaker aktif 2 unit', 'Mixer', 'Mic x4', 'Stand mic x4', 'Kabel audio'],
            ],

            // ── Fashion & Aksesoris ──
            [
                'name'        => 'Set Kebaya Brukat Navy',
                'description' => 'Set kebaya brukat lengkap untuk acara wisuda, pernikahan, dan formal.',
                'price_per_day' => 100000,
                'category_id' => $fashion->id,
                'kecamatan'   => 'Cibiru',
                'image'       => $img['kebaya'],
                'kelengkapan' => ['Atasan kebaya', 'Rok batik', 'Selendang', 'Inner', 'Hanger'],
            ],
            [
                'name'        => 'Jas Pria Slim Fit Hitam',
                'description' => 'Jas pria slim fit untuk acara formal, wisuda, dan pernikahan.',
                'price_per_day' => 150000,
                'category_id' => $fashion->id,
                'kecamatan'   => 'Andir',
                'image'       => $img['kebaya'],
                'kelengkapan' => ['Jas hitam', 'Celana panjang', 'Dasi', 'Saputangan saku'],
            ],
            [
                'name'        => 'Gaun Pesta Merah Mewah',
                'description' => 'Gaun pesta warna merah untuk gala dinner dan pesta formal.',
                'price_per_day' => 250000,
                'category_id' => $fashion->id,
                'kecamatan'   => 'Bandung Kidul',
                'image'       => $img['kebaya'],
                'kelengkapan' => ['Gaun pesta merah', 'Inner gaun', 'Hanger'],
            ],
            [
                'name'        => 'Baju Adat Sunda Pria',
                'description' => 'Baju adat Sunda lengkap untuk acara adat dan pernikahan.',
                'price_per_day' => 175000,
                'category_id' => $fashion->id,
                'kecamatan'   => 'Cinambo',
                'image'       => $img['kebaya'],
                'kelengkapan' => ['Baju pangsi hitam', 'Celana pangsi', 'Ikat kepala', 'Sarung', 'Sandal'],
            ],

            // ── Pesta & Event ──
            [
                'name'        => 'Tenda Pesta 5x10 Meter',
                'description' => 'Tenda pesta besar untuk acara pernikahan, ulang tahun, dan gathering.',
                'price_per_day' => 500000,
                'category_id' => $pesta->id,
                'kecamatan'   => 'Rancasari',
                'image'       => $img['tenda'],
                'kelengkapan' => ['1 unit tenda 5x10m', 'Tiang tenda', 'Pasak dan tali', 'Penutup samping'],
            ],
            [
                'name'        => 'Tenda Camping 4 Orang',
                'description' => 'Tenda dome waterproof untuk hiking dan kemping keluarga.',
                'price_per_day' => 80000,
                'category_id' => $pesta->id,
                'kecamatan'   => 'Coblong',
                'image'       => $img['tenda'],
                'kelengkapan' => ['Tenda dome + flysheet', 'Pasak tenda', 'Tali guy rope', 'Tas penyimpanan'],
            ],
            [
                'name'        => 'Proyektor Full HD Portable',
                'description' => 'Proyektor Full HD untuk presentasi, seminar, dan nonton bareng.',
                'price_per_day' => 150000,
                'category_id' => $pesta->id,
                'kecamatan'   => 'Cibiru',
                'image'       => $img['applewatch'],
                'kelengkapan' => ['Unit proyektor', 'Kabel HDMI', 'Remote', 'Layar 120 inch', 'Adaptor'],
            ],
            [
                'name'        => 'Kursi Tiffany 50 Unit',
                'description' => 'Paket 50 kursi Tiffany putih elegan untuk pernikahan dan pesta.',
                'price_per_day' => 300000,
                'category_id' => $pesta->id,
                'kecamatan'   => 'Panyileukan',
                'image'       => $img['tenda'],
                'kelengkapan' => ['50 unit kursi Tiffany putih', 'Pita hiasan'],
            ],

            // ── Rumah Tangga ──
            [
                'name'        => 'Kompor Listrik Portable',
                'description' => 'Kompor listrik portable untuk camping, kos-kosan, dan kebutuhan darurat.',
                'price_per_day' => 65000,
                'category_id' => $rumahTangga->id,
                'kecamatan'   => 'Cibiru',
                'image'       => $img['kompor'],
                'kelengkapan' => ['Unit kompor listrik', 'Kabel power', 'Panci kecil', 'Panduan penggunaan'],
            ],
            [
                'name'        => 'Mesin Kopi Espresso',
                'description' => 'Mesin kopi espresso untuk acara dan usaha kafe sementara.',
                'price_per_day' => 200000,
                'category_id' => $rumahTangga->id,
                'kecamatan'   => 'Bojongsoang',
                'image'       => $img['kopi'],
                'kelengkapan' => ['Unit mesin kopi', 'Portafilter', 'Tamper', 'Milk frother', 'Kabel power'],
            ],
            [
                'name'        => 'Air Fryer Philips 4.1L',
                'description' => 'Air fryer kapasitas besar untuk memasak sehat tanpa minyak banyak.',
                'price_per_day' => 75000,
                'category_id' => $rumahTangga->id,
                'kecamatan'   => 'Cibeunying Kidul',
                'image'       => $img['airfryer'],
                'kelengkapan' => ['Unit air fryer', 'Basket', 'Kabel power', 'Buku resep'],
            ],
            [
                'name'        => 'Vacuum Cleaner Dyson V15',
                'description' => 'Vacuum cleaner tanpa kabel untuk membersihkan rumah, sofa, dan kasur.',
                'price_per_day' => 100000,
                'category_id' => $rumahTangga->id,
                'kecamatan'   => 'Sukajadi',
                'image'       => $img['airfryer'],
                'kelengkapan' => ['Unit Dyson V15', 'Docking station', 'Brush head set', 'Charger'],
            ],
            [
                'name'        => 'Rice Cooker Jumbo 5L',
                'description' => 'Rice cooker kapasitas besar untuk acara dan hajatan.',
                'price_per_day' => 25000,
                'category_id' => $rumahTangga->id,
                'kecamatan'   => 'Rancaekek',
                'image'       => $img['kompor'],
                'kelengkapan' => ['Unit rice cooker', 'Spatula', 'Sendok takar', 'Kabel power'],
            ],

            // ── Hobi & Olahraga ──
            [
                'name'        => 'Sepeda Gunung MTB 27.5"',
                'description' => 'Sepeda gunung full suspension untuk trail dan olahraga akhir pekan.',
                'price_per_day' => 70000,
                'category_id' => $hobi->id,
                'kecamatan'   => 'Cileunyi',
                'image'       => $img['sepeda'],
                'kelengkapan' => ['Unit sepeda MTB', 'Helm MTB', 'Gembok', 'Lampu depan-belakang', 'Pompa mini'],
            ],
            [
                'name'        => 'Raket Tenis Keren',
                'description' => 'Raket tenis profesional untuk latihan dan turnamen.',
                'price_per_day' => 20000,
                'category_id' => $hobi->id,
                'kecamatan'   => 'Baleendah',
                'image'       => $img['raket'],
                'kelengkapan' => ['Raket tenis', 'Cover raket', 'Grip cadangan x2', 'Bola tenis 3 buah'],
            ],
            [
                'name'        => 'Gitar Akustik Gacor',
                'description' => 'Gitar akustik full size untuk pentas musik dan latihan.',
                'price_per_day' => 40000,
                'category_id' => $hobi->id,
                'kecamatan'   => 'Gedebage',
                'image'       => $img['gitar'],
                'kelengkapan' => ['Unit gitar akustik', 'Pick gitar x5', 'Capo', 'Tas gitar', 'Senar cadangan'],
            ],
            [
                'name'        => 'Matras Yoga Premium',
                'description' => 'Matras yoga anti-slip tebal 6mm untuk yoga, pilates, dan stretching.',
                'price_per_day' => 30000,
                'category_id' => $hobi->id,
                'kecamatan'   => 'Cicendo',
                'image'       => $img['raket'],
                'kelengkapan' => ['Matras yoga 6mm', 'Strap matras', 'Tas matras'],
            ],
            [
                'name'        => 'Set Drum Lengkap',
                'description' => 'Drum akustik 5 piece lengkap untuk latihan dan acara musik.',
                'price_per_day' => 200000,
                'category_id' => $hobi->id,
                'kecamatan'   => 'Lengkong',
                'image'       => $img['gitar'],
                'kelengkapan' => ['Bass drum', 'Snare drum', '2x Tom', 'Floor tom', 'Hi-hat', 'Pedal', 'Kursi drum'],
            ],
            [
                'name'        => 'Tenda Camping Ultralight',
                'description' => 'Tenda ultralight 2 orang untuk solo hiking dan backpacking.',
                'price_per_day' => 60000,
                'category_id' => $hobi->id,
                'kecamatan'   => 'Cimenyan',
                'image'       => $img['tenda'],
                'kelengkapan' => ['Tenda ultralight', 'Pasak titanium', 'Tali', 'Carry bag'],
            ],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(
                ['name' => $item['name']],
                array_merge($item, [
                    'user_id'               => $owner->id,
                    'stock'                 => 1,
                    'status'                => 'available',
                    'is_cod'                => true,
                    'is_delivery'           => true,
                    'has_deposit'           => false,
                    'late_fee_percentage'   => 10,
                    'deposit_amount'        => null,
                    'cancellation_policies' => [],
                ])
            );
        }

        $this->command->info('✅ ItemSeeder: ' . count($items) . ' item berhasil dibuat!');
    }
}