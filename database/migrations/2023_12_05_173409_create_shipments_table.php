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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shipment_no')->nullable()->comment('رقم تسلسلي للشحنة');
            $table->tinyInteger('is_split_payment')->default(0)->comment('هل الدفع للشحنة مقسم أم لا');
            $table->string('shipment_refrence')->nullable()->comment('الرقم المرجعي للشحنة');
            $table->date('delivered_date')->nullable()->comment('تاريخ التوصيل');
            $table->date('created_date')->nullable()->comment('تاريخ الانشاء');

            $table->unsignedBigInteger('status_id')->comment('(حالة الشحنة( قيد التسليم ... الخ')->default(10);
            $table->foreign('status_id')->references('id')->on('shipment_statuses')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('company_id')->comment('الشركة / التاجر')->nullable();
            $table->foreign('company_id')->references('id')->on('vendor_companies')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('rider_id')->comment('السائق')->nullable();
            $table->foreign('rider_id')->references('id')->on('riders')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('user_id')->comment('الزبون')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->float('shipment_amount')->nullable()->comment('سعر الشحنة');
            $table->float('delivery_fees')->nullable()->comment('رسوم التوصيل');
            $table->float('delivery_extra_fees')->nullable()->comment('رسوم توصيل اضافية');

            $table->float('rider_should_recive')->nullable()->comment('المبلغ الذي يجب استلامه من قبل السائق عند التسليم');
            $table->float('vendor_due')->nullable()->comment('المبلغ المستحق للتاجر من مبلغ الشحنة');
            $table->float('specialline_due')->nullable()->comment('المبلغ المستحق لشركة سبيشل لاين من مبلغ الشحنة');

            $table->tinyInteger('is_rider_has')->default(0)->comment('واحد : الأموال  مع السائق / صفر : ليس لدى السائق اموال');
            $table->tinyInteger('is_vendor_has')->default(0)->comment('واحد : الأموال  مع التاجر / صفر : ليس لدى التاجر اموال');
            $table->tinyInteger('is_bank_has')->default(0)->comment('واحد : الأموال  في البنك / صفر : ليس في البنك اموال');
            $table->tinyInteger('is_vendor_get_due')->default(0)->comment('واحد : تم حصول التاجر على مستحقاته / صفر : لم يتم حصول التاجر على مستحقاته');
            $table->tinyInteger('is_spl_get_due')->default(0)->comment('واحد : تم حصول سبيشل لاين على مستحقاته / صفر : لم يتم حصول سبيشل لاين على مستحقاته');

            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->unsignedBigInteger('fees_type_id')->comment('رسوم الشحن على من')->nullable();
            $table->foreign('fees_type_id')->references('id')->on('fees_types')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('branch_created')->comment('الفرع المنشأ للشحنة')->nullable();
            $table->foreign('branch_created')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('branch_destination')->comment('الفرع الوجهة')->nullable();
            $table->foreign('branch_destination')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('branch_delivered')->comment('الفرع الذي تم تسليم الشحنة به')->nullable();
            $table->foreign('branch_delivered')->references('id')->on('branches')->onDelete('cascade')->onUpdate('cascade');

            $table->tinyInteger('in_out')->nullable()->default(0)->comment("صفر : في حال كان الفرع المنشأ نفسه الفرع المسلم / واحد : في  حال كان الفرع المنشأ غير الفرع المسلم");
            $table->tinyInteger('is_migrated')->comment('تم ترحيل الشحنة كقيد أم لا')->default(0);

            $table->unsignedBigInteger('delivered_emirate_id')->nullable()->comment('الامارة التي سلمت بها الشحنة');
            $table->foreign('delivered_emirate_id')->references('id')->on('emirates');

            $table->unsignedBigInteger('delivered_city_id')->nullable()->comment('المدينة التي سلمت بها الشحنة');
            $table->foreign('delivered_city_id')->references('id')->on('cities');

            $table->string('delivered_address')->nullable()->comment('العنوان الذي سلمت به الشحنة');

            $table->string('shipment_notes')->nullable();

            $table->tinyInteger('is_external_order')->default(0)->comment('صفر شحنة  داخلية , واحد شحنة خارجية , اثنين شحنة دولية');
            $table->tinyInteger('Including_vat')->default(1)->comment('شاملة للضريبة أم لا (شاملة 1)');

            $table->string('shopify_order_id')->nullable()->comment('الشحنات المطلوبة من شوبيفاي');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
