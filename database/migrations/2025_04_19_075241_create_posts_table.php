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
            $table->id();
            $table->string('title');  // عنوان الوظيفة
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');  // ربط الوظيفة بالشركة
            $table->text('description');  // تفاصيل الوظيفة
            $table->decimal('salary', 8, 2);  // الراتب
            $table->text('contract_details');  // تفاصيل العقد
            $table->string('location');  // مكان الوظيفة
            $table->string('slug')->unique()->after('title');
            $table->boolean('paid')->default(true);  // هل الوظيفة مدفوعة أم لا
            $table->timestamp('posted_at')->nullable();  // تاريخ نشر الوظيفة
            $table->timestamp('expires_at')->nullable(); // تاريخ انتهاء الوظيفة
            $table->timestamps();
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
