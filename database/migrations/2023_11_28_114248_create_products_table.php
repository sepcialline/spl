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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('code');
            $table->integer('company_id');
            $table->integer('branch_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->tinyInteger('status')->default(0)->comment(' صفر غير فعال وواحد فعال');
            $table->string('cause_of_reject')->nullable()->comment('سبب الرفض');
            $table->decimal('price',10,2)->nullable()->comment('السعر');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
