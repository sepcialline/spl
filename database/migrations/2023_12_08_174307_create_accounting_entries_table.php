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
            $table->integer('compound_entry_with')->nullable()->comment('القيد مركب مع أي قيد');
            $table->integer('number')->nullable()->comment('رقم السند');
            $table->integer('payment_id')->nullable()->comment('الدفعة');
            $table->string('debit_account_number')->nullable()->comment('رقم الحساب المدين');
            $table->json('debit_account_name')->nullable()->comment('اسم الحساب المدين');
            $table->string('credit_account_number')->nullable()->comment('رقم الحساب المدين');
            $table->json('credit_account_name')->nullable()->comment('اسم الحساب المدين');
            $table->string('statment')->nullable()->comment('البيان');
            $table->double('amount_debit')->nullable()->comment('القيمة مدين');
            $table->double('amount_credit')->nullable()->comment('القيمة دائن');
            // $table->string('debit')->nullable()->comment('مدين وهو الحساب اللي اخذ ');
            // $table->string('credit')->nullable()->comment('دائن وهو الحساب اللي أعطى ');
            $table->date('transaction_date')->nullable()->comment('تاريخ العملية ');
            $table->date('posting_date')->nullable()->comment('تاريخ الترحيل ');
            $table->unsignedBigInteger('journal_type_id')->nullable()->comment('نوع السند');
            $table->foreign('journal_type_id')->references('id')->on('jounal_types');
            $table->tinyInteger('is_posted')->nullable()->default(0)->comment('صفر : غير مرحلة / واحد : مرحلة');
            $table->string('cost_center')->comment("مركز الكلفة في حالة المصاريف")->nullable();
            $table->string('shipment_id')->comment("رقم الشحنة")->nullable();
            $table->string('branch_id')->comment("الفرع في حال ادخال صرفيات من الفرع")->nullable();
            $table->string('statment_for_journal')->comment("بيان القيد ككل")->nullable();

            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();




            // إضافة الفهارس
            $table->index('compound_entry_with');
            $table->index('number');
            $table->index('payment_id');
            $table->index('debit_account_number');
            $table->index('credit_account_number');
            $table->index('transaction_date');
            $table->index('posting_date');
            $table->index('journal_type_id');
            $table->index('is_posted');
            $table->index('cost_center');
            $table->index('shipment_id');
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
