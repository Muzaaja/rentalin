<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah tabel pendukung transaksi:
     * - rental_extensions untuk riwayat perpanjangan
     * - additional_payments untuk tagihan tambahan kerusakan
     * - rental_cancellations untuk pembatalan pesanan
     */
    public function up(): void
    {
        if (!Schema::hasTable('rental_extensions')) {
            Schema::create('rental_extensions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();

                $table->date('old_end_date')->nullable();
                $table->date('new_end_date');
                $table->integer('extra_days')->default(0);
                $table->decimal('extension_price', 12, 2)->default(0);

                $table->enum('payment_type', ['full', 'paylater'])->default('full');
                $table->enum('payment_method', ['qris', 'paylater'])->default('qris');
                $table->enum('payment_status', ['pending', 'paid', 'paylater_aktif', 'failed'])->default('pending');

                $table->integer('installment_plan')->nullable();
                $table->integer('installment_paid')->default(0);
                $table->integer('installment_due_days')->nullable();
                $table->date('next_due_date')->nullable();

                $table->timestamps();
            });
        }

        if (!Schema::hasTable('additional_payments')) {
            Schema::create('additional_payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();
                $table->foreignId('damage_claim_id')->nullable()->constrained('damage_claims')->nullOnDelete();

                $table->decimal('amount', 12, 2)->default(0);
                $table->enum('payment_method', ['qris'])->default('qris');
                $table->enum('payment_status', ['menunggu_pembayaran', 'paid', 'failed'])->default('menunggu_pembayaran');
                $table->timestamp('paid_at')->nullable();

                $table->timestamps();
            });
        }

        if (!Schema::hasTable('rental_cancellations')) {
            Schema::create('rental_cancellations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();

                $table->string('cancelled_by')->nullable();
                $table->string('reason');
                $table->text('note')->nullable();

                $table->decimal('refund_amount', 12, 2)->default(0);
                $table->enum('refund_status', ['tidak_ada_refund', 'diproses', 'selesai'])->default('tidak_ada_refund');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_cancellations');
        Schema::dropIfExists('additional_payments');
        Schema::dropIfExists('rental_extensions');
    }
};