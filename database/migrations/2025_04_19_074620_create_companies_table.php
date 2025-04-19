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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الشركة
            $table->string('location'); // الموقع
            $table->string('industry'); // الصناعة
            $table->string('email')->unique(); // البريد الإلكتروني
            $table->string('phone_number')->nullable(); // رقم الهاتف
            $table->string('website')->nullable(); // الموقع الإلكتروني
            $table->string('logo')->nullable(); // الشعار
            $table->text('description')->nullable(); // الوصف
            $table->date('established_at')->nullable(); // تاريخ التأسيس
            $table->timestamps(); // الحقول الخاصة بتواريخ الإنشاء والتعديل
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
