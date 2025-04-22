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
    Schema::table('posts', function (Blueprint $table) {
        if (!Schema::hasColumn('posts', 'expires_at')) {
            $table->timestamp('expires_at')->nullable()->after('posted_at');  // إضافة العمود فقط إذا لم يكن موجودًا
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('expires_at'); // حذف عمود تاريخ انتهاء الوظيفة
        });
    }
};
