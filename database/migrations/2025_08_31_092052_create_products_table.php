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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("desc");
            $table->text("image");
            $table->text("face");
            $table->string("price");
            $table->string("code_prod");
            $table->string("name_company");
            $table->string("count_box");
            $table->string("count_meter");
            $table->string("count_palet");
            $table->string("count_all");
            $table->string("count_darageh");
            $table->string("no_product");
            $table->string("name_en");
            $table->text("desc_en");
            $table->string("name_ar");
            $table->text("desc_ar");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
