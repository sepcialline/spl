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
        Schema::create('vendor_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sales_id')->nullable();
            $table->integer('account_number')->unique()->nullable();
            $table->json('name');
            $table->double('vendor_rate', 10, 2)->nullable();
            $table->double('customer_rate', 10, 2)->nullable();
            $table->string('logo', 255)->nullable();
            $table->tinyInteger('emirate_id')->nullable();
            $table->tinyInteger('has_stock')->default(0)->nullable();
            $table->tinyInteger('city_id')->nullable();
            $table->tinyInteger('has_api')->nullable();
            $table->json('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('description');
            $table->string('bank_name');
            $table->string('iban');
            $table->double('commission_rate', 10, 2)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('delete_by')->nullable();
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
        Schema::dropIfExists('vendor_companies');
    }
};
