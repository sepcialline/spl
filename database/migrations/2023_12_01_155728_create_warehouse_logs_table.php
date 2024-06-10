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
        Schema::create('warehouse_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('branch_id');
            $table->integer('company_id');
            $table->integer('warehouse_id');
            $table->integer('quantity');
            $table->date('date')->nullable();
            $table->integer('operation_id'); //1:import 2:export 3:adjust 4:transfer 5:add 6:deliver
            $table->string('dispatch_ref_no');
            $table->string('notes')->nullable();
            $table->string('added_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_logs');
    }
};
