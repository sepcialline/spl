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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->nullable()->comment('رقم الطلب');
            $table->string('company_id')->nullable()->comment('الشركة');
            $table->string('service_id')->nullable()->comment('نوع الطلب');
            $table->tinyInteger('status')->nullable()->default(1)->comment('حالة الطلب  - واحد قيد الموافقة -اثنين  تمت الموافقة - ثلاثة تم الرفض - أربعة تأجيل');
            $table->string('created_date')->nullable()->comment('تاريخ الطلب');
            $table->string('created_by')->nullable()->comment('انشأت من قبل');
            $table->string('approved_date')->nullable()->comment('تاريخ الموافقة');
            $table->string('approved_by')->nullable()->comment('الموافقة من قبل');
            $table->string('declined_date')->nullable()->comment('تاريخ الرفض ');
            $table->string('declined_by')->nullable()->comment(' رفضت من قبل ');
            $table->longText('cause')->nullable()->comment('  السبب في حال الرفض أو التأجيل');
            $table->longText('notes')->nullable()->comment('ملاحظات');
            $table->string('guard_created')->nullable();
            $table->string('guard_approved')->nullable();
            $table->string('guard_declined')->nullable();
            $table->string('guard_delyed')->nullable();
            $table->string('delayed_by')->nullable();
            $table->string('delayed_date')->nullable();
            $table->tinyInteger('is_closed')->default(0)->comment('صفر مفتوحة  واحد مغلقة');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
