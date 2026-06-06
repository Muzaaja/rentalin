<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Menambahkan kolom delivery_method setelah kolom end_date
            $table->enum('delivery_method', ['cod', 'delivery'])->nullable()->after('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('delivery_method');
        });
    }
};