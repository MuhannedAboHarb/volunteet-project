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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('job_id')->constrained('posts')->onDelete('cascade');
        $table->text('cover_letter')->nullable()->change();  // جعل cover_letter يقبل القيم الفارغة
        $table->text('cv')->nullable()->change();  // جعل cv يقبل القيم الفارغة
        $table->text('cover_letter_text')->nullable()->change();  // جعل cover_letter_text يقبل القيم الفارغة
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // حالة التقديم
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
