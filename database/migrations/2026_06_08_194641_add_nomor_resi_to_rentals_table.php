<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // menambah kolom nomor resi ke tabel rentals
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->string('nomor_resi')->nullable();
        });
    }

    // menghapus kolom nomor resi kalau migration di-rollback
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('nomor_resi');
        });
    }
};