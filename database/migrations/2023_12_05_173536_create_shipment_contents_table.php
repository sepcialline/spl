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
        Schema::create('shipment_contents', function (Blueprint $table) {
            $table->id();

            $table->integer('shipment_id')->comment('الشحنة');
            // $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('product_id')->comment('المنتج')->nullable();
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');

            $table->string('content_text')->comment('المنتج في حال لم يكن في الستوك')->nullable();

            $table->integer('quantity')->comment('الكمية')->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('delete_by')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_contents');
    }
};
