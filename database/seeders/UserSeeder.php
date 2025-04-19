<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'prof',
            'email' => 'prof@gmail.com',
            'password' => Hash::make('12345678'), // هنا نستخدم Hash لجعل كلمة المرور مشفرة
            'role' => 'admin', // تأكد من إضافة هذه الخاصية إذا كانت موجودة
            'is_volunteer' => false, // هنا نفترض أن المستخدم ليس متطوعًا، يمكنك تعديله
        ]);
    }
}
