<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyimpan foto dokumentasi tiap proses transaksi rental.
     */
    public function up(): void
    {
        Schema::create('rental_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_id')
                ->constrained('rentals')
                ->cascadeOnDelete();

            $table->enum('process', [
                'owner_shipping',
                'owner_handover',
                'tenant_acceptance',
                'tenant_return',
                'owner_return_check',
                'damage_claim',
            ]);

            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel dokumentasi jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_documents');
    }
};