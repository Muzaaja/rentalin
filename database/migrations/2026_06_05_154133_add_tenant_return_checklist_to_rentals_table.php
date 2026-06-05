<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom checklist saat penyewa mengembalikan barang.
     */
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (!Schema::hasColumn('rentals', 'tenant_return_checklist')) {
                $table->json('tenant_return_checklist')->nullable()->after('accepted_checklist');
            }
        });
    }

    /**
     * Hapus kolom jika rollback.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'tenant_return_checklist')) {
                $table->dropColumn('tenant_return_checklist');
            }
        });
    }
};