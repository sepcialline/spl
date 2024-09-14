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
        Schema::create('compensation_request_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compensation_request_id')->constrained('compensation_requests')->onDelete('cascade')->onUpdate('cascade');
            $table->string('shipment')->nullable();
            $table->double('amount',10,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compensation_request_infos');
    }
};
