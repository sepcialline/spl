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
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('related_to')->nullable();
            $table->json('name');
            $table->string('mobile')->nullable();
            $table->string('email')->unique();
            $table->string('avatar', 255)->nullable();
            $table->timestamp('email_verified_at');
            $table->string('password');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('vendor_companies')->onDelete('cascade')->onUpdate('cascade');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('delete_by')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->integer('nationality_id')->nullable();
            $table->dateTime('birthdate')->nullable();
            $table->tinyInteger('gender')->comment('1 male , 2 female');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
