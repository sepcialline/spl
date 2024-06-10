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
        Schema::create('account_trees', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('account_level')->comment("المستوى")->nullable();
            $table->integer('account_code')->comment("رمز الحساب")->nullable();
            $table->json('account_name')->comment("اسم الحساب")->nullable();
            $table->tinyInteger('account_type')->comment("صفر رئيسي و واحد فرعي")->nullable();
            $table->tinyInteger('account_parent')->comment("الحساب الأب")->nullable();
            $table->tinyInteger('account_dc_type')->comment("صفر دائن و واحد مدين")->nullable();
            $table->tinyInteger('account_final')->comment(" واحد : الميزانية - اثنين : الأرباح والخسائر - ثلاثة : المتاجرة الحساب الختامي")->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('deleted_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_trees');
    }
};
