<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyimpan klaim kerusakan dari pemilik.
     */
    public function up(): void
    {
        Schema::create('damage_claims', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_id')
                ->constrained('rentals')
                ->cascadeOnDelete();

            $table->string('damage_type')->nullable();
            $table->string('damage_part')->nullable();
            $table->text('description');
            $table->decimal('repair_fee', 12, 2)->default(0);

            $table->enum('status', [
                'submitted',
                'accepted',
                'paid',
            ])->default('submitted');

            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel klaim kerusakan jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_claims');
    }
};