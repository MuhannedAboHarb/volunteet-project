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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // ربط التقديم بالمتطوع
            $table->foreignId('job_id')->constrained()->onDelete('cascade');   // ربط التقديم بالوظيفة
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');  // حالة الطلب
            $table->date('interview_date')->nullable();  // تاريخ المقابلة
            $table->text('reason_for_rejection')->nullable();  // السبب في حال رفض الطلب
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
