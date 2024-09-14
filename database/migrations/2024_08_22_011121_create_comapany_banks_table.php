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
        Schema::create('company_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('vendor_companies');

            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');

            $table->string('iban_number')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_default')->default(0);
            $table->string('name_owner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comapany_banks');
    }
};
