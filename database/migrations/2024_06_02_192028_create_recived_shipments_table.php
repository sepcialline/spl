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
        Schema::create('recived_shipments', function (Blueprint $table) {
            $table->id();
            $table->integer('rider_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('vendor_if_not_in_system')->nullable();
            $table->integer('count_of_shipments')->nullable();
            $table->string('date')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('is_approved')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recived_shipments');
    }
};
