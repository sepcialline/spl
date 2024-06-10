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
        Schema::create('accounting_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->nullable()->comment('رقم السند');
            $table->string('account_number')->nullable()->comment('رقم الحساب');
            $table->string('account_name')->nullable()->comment('اسم الحساب');
            $table->string('statment')->nullable()->comment('البيان');
            $table->string('debit')->nullable()->comment('مدين وهو الحساب اللي اخذ ');
            $table->string('credit')->nullable()->comment('دائن وهو الحساب اللي أعطى ');
            $table->date('transaction_date')->nullable()->comment('تاريخ العملية ');
            $table->date('posting_date')->nullable()->comment('تاريخ الترحيل ');
            $table->unsignedBigInteger('journal_type_id')->nullable()->comment('نوع السند');
            $table->foreign('journal_type_id')->references('id')->on('jounal_types');
            $table->tinyInteger('is_posted')->nullable()->default(0)->comment('صفر : غير مرحلة / واحد : مرحلة');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_entries');
    }
};
