<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Menambahkan kolom tambahan agar rentals bisa dipakai sebagai tabel transaksi utama.
     */
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('rental_code')->nullable()->unique()->after('id');

            $table->boolean('acceptance_complete')
                ->nullable()
                ->after('status');

            $table->text('acceptance_note')
                ->nullable()
                ->after('acceptance_complete');

            $table->text('return_note')
                ->nullable()
                ->after('acceptance_note');

            $table->text('damage_description')
                ->nullable()
                ->after('return_note');

            $table->decimal('damage_fee', 12, 2)
                ->nullable()
                ->after('damage_description');
        });

        DB::statement("
            ALTER TABLE rentals 
            MODIFY status ENUM(
                'pesanan_masuk',
                'menunggu_pembayaran',
                'pembayaran_berhasil',
                'diproses',
                'dikirim',
                'menunggu_penerimaan',
                'disewa',
                'pengembalian',
                'belum_dikembalikan',
                'kerusakan',
                'selesai',
                'dibatalkan'
            ) NOT NULL DEFAULT 'pesanan_masuk'
        ");
    }

    /**
     * Menghapus kolom tambahan jika rollback.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn([
                'rental_code',
                'acceptance_complete',
                'acceptance_note',
                'return_note',
                'damage_description',
                'damage_fee',
            ]);
        });

        DB::statement("
            ALTER TABLE rentals 
            MODIFY status ENUM(
                'pending',
                'paid',
                'ongoing',
                'returned',
                'cancelled'
            ) NOT NULL DEFAULT 'pending'
        ");
    }
};