<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * عرض نموذج التسجيل.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * معالجة تسجيل المستخدم.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // تأكد من أن البريد الإلكتروني فريد
            'password' => 'required|string|min:8|confirmed',  // تأكد من تطابق كلمة المرور مع التأكيد
        ]);

        // إنشاء المستخدم في قاعدة البيانات
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // تأكد من تشفير كلمة المرور
        ]);

        // تسجيل الدخول مباشرة بعد التسجيل
        auth()->login($user);

        // إعادة التوجيه بعد التسجيل الناجح
        return redirect()->route('filament.pages.dashboard');
        // هنا يتم توجيه المستخدم إلى لوحة التحكم الخاصة به (أو صفحة أخرى)
    }
}
