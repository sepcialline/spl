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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('is_split')->nullable()->default(0)->comment('دفع مقسم أم لا');
            $table->string('payment_number')->nullable()->comment(' رقم الدفع');

            $table->string('image')->nullable()->comment('صورة اشعار الدفع');

            $table->unsignedBigInteger('shipment_id')->comment('الشحنة');
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade')->onUpdate('cascade');

            $table->date('date')->comment('تاريخ عملية الدفع');

            $table->unsignedBigInteger('payment_method_id')->comment('طريقة الدفع / كاش - لسبيشل لاين - للتاجر ');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('company_id')->comment('الشركة - التاجر');
            $table->foreign('company_id')->references('id')->on('vendor_companies')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('rider_id')->comment('السائق');
            $table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade')->onUpdate('cascade');

            $table->float('amount', 10, 2)->nullable()->comment('مبلغ الدفعة');
            $table->float('delivery_fees',10,2)->nullable()->comment('رسوم التوصيل');
            $table->float('due_amount',10,2)->nullable()->comment('المبلغ المستحق');

            $table->tinyInteger('is_rider_has')->default(0)->comment('واحد : الأموال  مع السائق / صفر : ليس لدى السائق اموال');
            $table->tinyInteger('is_vendor_has')->default(0)->comment('واحد : الأموال  مع التاجر / صفر : ليس لدى التاجر اموال');
            $table->tinyInteger('is_bank_has')->default(0)->comment('واحد : الأموال  في البنك / صفر : ليس في البنك اموال');
            $table->tinyInteger('is_spl_get_due')->default(0)->comment('واحد : تم حصول سبيشل لاين على مستحقاتها / صفر : لم يتم حصول سبيشل لاين على مستحقاتها');
            $table->tinyInteger('is_vendor_get_due')->default(0)->comment('واحد : تم حصول التاجر على مستحقاته / صفر : لم يتم حصول التاجر على مستحقاته');

            // $table->float('shipment_amount')->nullable()->comment('سعر الشحنة');
            // $table->float('delivery_fees')->nullable()->comment('رسوم التوصيل');
            // $table->float('delivery_extra_fees')->nullable()->comment('رسوم توصيل اضافية');
            // $table->float('shipment_due')->nullable()->comment('المبلغ المستحق للشحنة');

            $table->unsignedBigInteger('branch_created')->comment('الفرع المنشأ للدفعة')->nullable();
            $table->foreign('branch_created')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');

            $table->tinyInteger('posted_journal_voucher')->comment('هل ترحلت لقيد محاسبي أم لا')->default(0);

            $table->tinyInteger('in_out')->nullable()->default(0)->comment("صفر : في حال كان الفرع المنشأ نفسه الفرع المسلم / واحد : في  حال كان الفرع المنشأ غير الفرع المسلم");


            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('delete_by')->nullable();

            // بيانات اضافية لبريد الامارات
            $table->string('origin_country')->default('United Arab Emirates');
            $table->string('origin_city')->default('Ajman');
            $table->string('destination_country')->default('United Arab Emirates');
            $table->string('shipment_type')->default('document');
            $table->string('shipment_status')->default('Delivered');
            $table->string('weight')->default('0');
            $table->string('destination_city')->default('عجمان');
            $table->string('additional_info_2')->nullable()->default('');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
