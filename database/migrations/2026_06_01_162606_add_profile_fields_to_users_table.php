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
        Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable();
        $table->string('avatar')->nullable();
        $table->text('address')->nullable();

        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('city')->nullable();
        $table->string('province')->nullable();
        $table->string('postal_code')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'phone',
            'avatar',
            'address',
            'first_name',
            'last_name',
            'city',
            'province',
            'postal_code',
        ]);
    });
    }
};
