<?php

use App\Filament\Resources\CompanyResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\VolunteerController;

// مسار الصفحة الرئيسية
Route::get('/', function () {
    return redirect()->route('register');  // توجيه إلى صفحة التسجيل
});

// مسارات التسجيل
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.submit');

// مسارات تسجيل الدخول والخروج
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// بعد التسجيل، توجيه المتطوع إلى لوحة التحكم الخاصة بـ Filament
Route::get('/admin', function () {
    return redirect()->route('filament.dashboard');  // إعادة التوجيه إلى لوحة تحكم Filament
})->middleware('auth'); // تأكد من أن المتطوع مسجل دخوله

// إدارة المتطوعين والشركات
Route::resource('volunteers', VolunteerController::class);

Route::get('/companies', [CompanyResource::class, 'index'])->name('companies.index');
Route::get('/companies/create', [CompanyResource::class, 'create'])->name('companies.create');
Route::get('/companies/{company}/edit', [CompanyResource::class, 'edit'])->name('companies.edit');

Route::get('apply-job/{post_id}', [JobApplicationController::class, 'apply'])->name('apply-job');
