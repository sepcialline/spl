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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('photo')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('emirate_id')->nullable();
            $table->tinyInteger('city_id')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->text('address')->nullable();
            $table->string('longitude')->nullable()->default(0);
            $table->string('latitude')->nullable()->default(0);
            $table->string('created_by')->nullable()->default('Web Servers');;
            $table->string('updated_by')->nullable();
            $table->string('delete_by')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
