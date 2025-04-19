<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إضافة مستخدم مبدئي في جدول users
        User::create([
            'name' => 'prof', // اسم المستخدم
            'email' => 'prof@gmail.com', // البريد الإلكتروني
            'password' => Hash::make('12345678'), // كلمة المرور مشفرة
            'role' => 'admin', // الدور (مستخدم مسؤول)
            'is_volunteer' => false, // المستخدم ليس متطوعًا
        ]);

        // يمكنك إضافة المزيد من المستخدمين أو البيانات الأخرى إذا لزم الأمر
    }
}
