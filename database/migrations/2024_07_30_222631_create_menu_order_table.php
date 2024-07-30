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
        Schema::create('menu_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->float('price', 2);
            $table->integer('quantity')->default(1);
            $table->timestamps();
            $table->authors();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_order');
    }
};
