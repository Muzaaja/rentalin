<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toko', function (Blueprint $table) {
            $table->id();

            // Relasi ke user pemilik toko
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // ── Step 1: Info Toko ──
            $table->string('nama_toko');
            $table->string('alamat_toko');
            $table->text('deskripsi')->nullable();
            $table->string('no_telepon');

            // ── Step 2: Verifikasi Identitas ──
            $table->string('nik', 16);
            $table->string('nama_lengkap_ktp');
            $table->string('foto_ktp');      // path file
            $table->string('foto_selfie');   // path file

            // ── Step 2: Rekening Pencairan ──
            $table->string('nama_bank');
            $table->string('nomor_rekening');
            $table->string('nama_pemilik_rekening');

            // Status verifikasi toko oleh admin
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};