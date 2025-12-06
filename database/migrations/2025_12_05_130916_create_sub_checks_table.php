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
        Schema::create('sub_checks', function (Blueprint $table) {
            $table->id();
            $table->string('check_date');
            $table->string('name_user');
            $table->string('phone_user');
            $table->string('name_bank');
            $table->string('name_branch');
            $table->string('code_branch');
            $table->string('check_serial');
            $table->string('check_num');
            $table->string('check_price');
            $table->string('name_account');
            $table->string('num_account');
            $table->string('num_invocie');
            $table->string('desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_checks');
    }
};
