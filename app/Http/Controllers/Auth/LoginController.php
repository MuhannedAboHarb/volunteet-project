<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * عرض نموذج تسجيل الدخول.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * معالجة بيانات تسجيل الدخول.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',  // التأكد من وجود الإيميل في قاعدة البيانات
            'password' => 'required|string|min:8',           // التأكد من أن كلمة المرور صحيحة
        ]);

        // محاولة تسجيل الدخول
        if (Auth::attempt($validatedData)) {
            // في حال تم التسجيل بنجاح
            return redirect()->intended('/dashboard');  // إعادة التوجيه إلى صفحة لوحة التحكم أو المسار الذي تم الوصول إليه
        }

        // في حال فشل الدخول
        return back()->withErrors([
            'email' => 'معلومات تسجيل الدخول غير صحيحة.',
        ]);
    }

    /**
     * تسجيل الخروج من الجلسة.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();  // تسجيل الخروج
        return redirect('/login');  // إعادة التوجيه إلى صفحة تسجيل الدخول
    }
}
