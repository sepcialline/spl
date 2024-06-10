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
        Schema::create('c_o_a_level_i_s', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')->references('id')->on('c_o_a_s')->onDelete('cascade')->onUpdate('cascade');

            $table->string('code')->nullable()->unique();
            $table->json('name')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_o_a_level_i_s');
    }
};
