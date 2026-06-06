<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('late_fee_percentage')->nullable()->after('price_per_day');
            $table->boolean('has_deposit')->default(false)->after('late_fee_percentage');
            $table->decimal('deposit_amount', 12, 2)->nullable()->after('has_deposit');
            $table->json('cancellation_policies')->nullable()->after('deposit_amount');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn([
                'late_fee_percentage',
                'has_deposit',
                'deposit_amount',
                'cancellation_policies'
            ]);
        });
    }
};