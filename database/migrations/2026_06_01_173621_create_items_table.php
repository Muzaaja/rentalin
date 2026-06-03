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
        Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

        $table->foreignId('category_id')
          ->constrained()
          ->cascadeOnDelete();

        $table->string('name');

        $table->text('description');

        $table->decimal('price_per_day',12,2);

        $table->integer('stock')->default(1);

        $table->string('image')->nullable();

        $table->enum('status',[
            'available',
            'rented',
            'inactive'
        ])->default('available');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
