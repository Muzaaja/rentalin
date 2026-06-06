<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penyewa'); // Menyimpan nama pembuat ulasan
            $table->string('produk');       // Menyimpan nama produk yang disewa
            $table->integer('rating');      // Menyimpan angka rating (1-5)
            $table->text('komentar');       // Isi ulasan dari penyewa
            $table->text('reply_text')->nullable(); // Tempat menyimpan balasan dari toko kamu (boleh kosong)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};
