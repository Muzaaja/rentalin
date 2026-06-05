<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom:
     * - items.kelengkapan
     * - rentals.outgoing_checklist
     * - rentals.accepted_checklist
     * - rentals.returned_checklist
     * - payments kolom paylater
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            if (!Schema::hasColumn('items', 'kelengkapan')) {
                $table->json('kelengkapan')->nullable()->after('description');
            }
        });

        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'outgoing_checklist')) {
                $table->json('outgoing_checklist')->nullable()->after('return_note');
            }

            if (!Schema::hasColumn('rentals', 'accepted_checklist')) {
                $table->json('accepted_checklist')->nullable()->after('outgoing_checklist');
            }

            if (!Schema::hasColumn('rentals', 'returned_checklist')) {
                $table->json('returned_checklist')->nullable()->after('accepted_checklist');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'payment_type')) {
                $table->enum('payment_type', ['full', 'paylater'])->default('full')->after('payment_method');
            }

            if (!Schema::hasColumn('payments', 'installment_plan')) {
                $table->unsignedTinyInteger('installment_plan')->nullable()->after('payment_type');
            }

            if (!Schema::hasColumn('payments', 'installment_paid')) {
                $table->unsignedTinyInteger('installment_paid')->default(0)->after('installment_plan');
            }

            if (!Schema::hasColumn('payments', 'installment_due_days')) {
                $table->unsignedTinyInteger('installment_due_days')->nullable()->after('installment_paid');
            }

            if (!Schema::hasColumn('payments', 'next_due_date')) {
                $table->date('next_due_date')->nullable()->after('installment_due_days');
            }

            if (!Schema::hasColumn('payments', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'partially_paid', 'overdue'])
                    ->default('pending')
                    ->after('next_due_date');
            }
        });
    }

    /**
     * Rollback kolom yang ditambahkan.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'payment_status')) {
                $table->dropColumn('payment_status');
            }

            if (Schema::hasColumn('payments', 'next_due_date')) {
                $table->dropColumn('next_due_date');
            }

            if (Schema::hasColumn('payments', 'installment_due_days')) {
                $table->dropColumn('installment_due_days');
            }

            if (Schema::hasColumn('payments', 'installment_paid')) {
                $table->dropColumn('installment_paid');
            }

            if (Schema::hasColumn('payments', 'installment_plan')) {
                $table->dropColumn('installment_plan');
            }

            if (Schema::hasColumn('payments', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
        });

        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'returned_checklist')) {
                $table->dropColumn('returned_checklist');
            }

            if (Schema::hasColumn('rentals', 'accepted_checklist')) {
                $table->dropColumn('accepted_checklist');
            }

            if (Schema::hasColumn('rentals', 'outgoing_checklist')) {
                $table->dropColumn('outgoing_checklist');
            }
        });

        Schema::table('items', function (Blueprint $table) {
            if (Schema::hasColumn('items', 'kelengkapan')) {
                $table->dropColumn('kelengkapan');
            }
        });
    }
};