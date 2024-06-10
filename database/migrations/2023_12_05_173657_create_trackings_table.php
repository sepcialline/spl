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
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shipment_id')->comment('الشحنة');
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('status_id');
            $table->integer('rider_id')->nullable();
            $table->foreign('status_id')->references('id')->on('shipment_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->nullable();
            $table->string('guard')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('vendor_companies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('notes')->nullable();
            $table->datetime('time');
            $table->string('action');
            $table->float('shipment_amount')->nullable()->comment('سعر الشحنة');
            $table->float('delivery_fees')->nullable()->comment('رسوم التوصيل');
            $table->float('delivery_extra_fees')->nullable()->comment('رسوم توصيل اضافية');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackings');
    }
};
