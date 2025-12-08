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
        Schema::create('lpo__prods', function (Blueprint $table) {
            $table->id();
            $table->string('lpo_id')->nullable();
            $table->string('prod_id')->nullable();
            $table->string('count_box')->nullable();
            $table->string('count_palet')->nullable();
            $table->string('count_all')->nullable();
            $table->string('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpo__prods');
    }
};
