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
        Schema::create('cart_prods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('card_id');
            $table->bigInteger('prod_id');
            $table->string('count_box');
            $table->string('count_palet');
            $table->string('price');
            $table->string('off');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_prods');
    }
};
