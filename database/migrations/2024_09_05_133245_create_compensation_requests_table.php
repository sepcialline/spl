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
        Schema::create('compensation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('number')->nullable()->comment('رقم الطلب');
            $table->integer('company_id')->nullable()->comment('الشركة');

            $table->longText('store_report')->nullable()->comment('تقرير المستودع');
            $table->string('store_keeper')->nullable()->comment('موظف المستودع');
            $table->string('store_keeper_signature')->nullable()->comment('توقيع موظف المستودع');
            $table->tinyInteger('store_check')->nullable()->comment('مصدق من المستودع')->default(0);

            $table->longText('operation_report')->nullable()->comment('تقرير العمليات');
            $table->string('operation')->nullable()->comment('موظف العمليات');
            $table->string('operation_signature')->nullable()->comment('توقيع موظف العمليات');
            $table->tinyInteger('operation_check')->nullable()->comment('مصدق من العمليات')->default(0);


            $table->tinyInteger('ceo_check')->comment('مصدق من المدير التنفيذي')->default(0);
            $table->tinyInteger('decline_check')->default(0)->comment('رفض في حال كانت 1 وصفر لا');
            $table->longText('ceo_report')->nullable()->comment('تقرير المدير التنفيذي');
            $table->string('ceo')->nullable()->comment(' المدير التنفيذي');
            $table->string('ceo_signature')->nullable()->comment('توقيع  المدير التنفيذي');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compensation_requests');
    }
};
