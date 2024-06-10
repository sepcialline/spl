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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
			$table->json('branch_name', 255);
			$table->integer('branch_emirat_id');
			$table->string('branch_mobile')->nullable();
            $table->string('branch_landline')->nullable();
			$table->string('branch_email')->nullable();
			$table->string('branch_address', 255)->nullable();
			$table->string('branch_postal_code')->nullable();
            $table->integer('is_main')->default('0')->nullable();
            $table->integer('percentage')->default('0')->nullable()->comment('اذا كان هناك نسبة للشحنات تكون 1 او 0  انه قيمة التوصيل كاملة للفرع');
            $table->double('percentage_in', 10.2)->default('0')->nullable();
            $table->double('percentage_out', 10.2)->default('0')->nullable();
			$table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('delete_by')->nullable();
			$table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
