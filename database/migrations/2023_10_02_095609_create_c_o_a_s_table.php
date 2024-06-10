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
        Schema::create('c_o_a_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trial_balance_id');
            $table->foreign('trial_balance_id')->references('id')->on('trial_balances')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('c_o_a_s');
    }
};
