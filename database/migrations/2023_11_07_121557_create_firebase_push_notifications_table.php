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
        Schema::create('firebase_push_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('server_key')->nullable();
            $table->string('api_key')->nullable();
            $table->string('project_id')->nullable();
            $table->string('auth_domain')->nullable();
            $table->string('storage_bucket')->nullable();
            $table->string('messaging_sender_id')->nullable();
            $table->string('app_id')->nullable();
            $table->string('measurment_id')->nullable();
            $table->json('pending')->nullable();
            $table->json('confirm')->nullable();
            $table->json('delivere')->nullable();
            $table->json('delay')->nullable();
            $table->json('transfer')->nullable();
            $table->json('cancel')->nullable();
            $table->json('damage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firebase_push_notifications');
    }
};
