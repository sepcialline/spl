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
        Schema::create('transfer_products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('from_branch');
            $table->integer('to_branch');
            $table->integer('quantity');
            $table->tinyInteger('deliver_status'); //0->not delivered 1->delivered
            $table->integer('done_by');
            $table->integer('delivered_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_products');
    }
};
