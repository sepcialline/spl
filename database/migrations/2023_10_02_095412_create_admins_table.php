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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('mobile')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('is_sales')->default(0)->nullable();
            $table->string('photo')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('department_id')->nullable();
            $table->tinyInteger('is_department_head')->default(0);
            $table->tinyInteger('emirate_id')->nullable();
            $table->tinyInteger('city_id')->nullable();
            $table->tinyInteger('branch_id')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('admins');
    }
};
