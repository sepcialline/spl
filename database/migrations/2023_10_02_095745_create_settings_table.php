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
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->json('name', 255)->nullable();
            $table->json('description')->nullable();
			$table->string('logo_en')->nullable();
            $table->string('logo_ar')->nullable();
			$table->string('favicon')->nullable();
			$table->string('url', 255)->nullable();
			$table->string('email', 255)->nullable();
			$table->string('landline', 255)->nullable();
			$table->integer('emirates_post_license_no')->nullable();
			$table->string('mobile', 255)->nullable();
			$table->string('postal_code', 255)->nullable();
			$table->json('address')->nullable();
			$table->string('map_longitude')->nullable();
            $table->string('map_latitude')->nullable();
            $table->integer('currency')->default('1')->nullable();
			$table->string('tax')->nullable();
            $table->boolean('tax_include')->nullable()->default(true);
			$table->double('tax_percentage', 10.2)->default('5')->nullable();
			$table->string('default_language')->nullable();
            $table->string('timezone')->default('Asia/Dubai')->nullable();
			$table->string('date_format')->nullable();
			$table->string('time_format')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
			$table->boolean('maintenance_mode')->default(false)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
