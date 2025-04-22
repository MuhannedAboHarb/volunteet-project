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
        Schema::create('posts', function (Blueprint $table) {
        $table->id();  // معرف الوظيفة (مفتاح رئيسي)
        $table->string('title');  // عنوان الوظيفة
        $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');  // ربط الوظيفة بالشركة
        $table->text('description');  // تفاصيل الوظيفة
        $table->decimal('salary', 8, 2);  // الراتب
        $table->text('contract_details')->nullable();  // جعل هذا الحقل يقبل القيم الفارغة (nullable)
        $table->string('location');  // مكان الوظيفة
        $table->string('slug')->unique();  // رابط الوظيفة (slug)
        $table->boolean('paid')->default(1);  // مدفوعة أم لا
        $table->timestamp('posted_at')->nullable();  // تاريخ نشر الوظيفة
        $table->timestamp('expires_at')->nullable(); // تاريخ انتهاء الوظيفة
        $table->timestamps();  // أوقات الإنشاء والتحديث
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
