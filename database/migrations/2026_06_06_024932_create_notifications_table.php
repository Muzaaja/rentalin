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
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            // User penerima notifikasi
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi rental (opsional)
            $table->foreignId('rental_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Relasi payment (opsional)
            $table->foreignId('payment_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Judul notifikasi
            $table->string('title');

            // Isi notifikasi
            $table->text('message');

            // request, payment, return, damage, extend, dll
            $table->string('type');

            // baru, berhasil, pending, selesai, dll
            $table->string('status')->nullable();

            // icon (opsional)
            $table->string('icon')->nullable();

            // url tujuan ketika diklik
            $table->string('url')->nullable();

            // sudah dibaca atau belum
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};