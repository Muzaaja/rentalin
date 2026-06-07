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
        Schema::table('chats', function (Blueprint $table) {
            $table->unsignedBigInteger('rental_id')->nullable()->after('id');
            $table->boolean('is_read')->default(false)->after('message');

            $table->foreign('rental_id')
                ->references('id')
                ->on('rentals')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign(['rental_id']);
            $table->dropColumn(['rental_id', 'is_read']);
        });
    }
};
