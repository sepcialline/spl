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
        Schema::create('shopify_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("app_id")->nullable();
            $table->integer("order_number")->nullable();
            $table->bigInteger("order_id")->nullable();
            $table->string("customer_name")->nullable();
            $table->string("phone_no")->nullable();
            $table->string("email")->nullable();
            $table->integer('company_id');
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("emirate")->nullable();
            $table->string("longitude")->nullable();
            $table->string("latitude")->nullable();
            $table->float("subtotal_price")->nullable();
            $table->float("discount")->nullable();
            $table->float("shipping_price")->nullable();
            $table->float("tax")->nullable();
            $table->float("total_price")->nullable();
            $table->string("currency")->nullable();
            $table->integer("status")->default(0);
            $table->string("payment_gateway_names")->nullable();
            $table->string("financial_status")->nullable()->comment('financial_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopify_orders');
    }
};
