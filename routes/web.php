<?php

use App\Filament\Resources\CompanyResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VolunteerController;

// مسارات التسجيل
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.submit');


// مسارات تسجيل الدخول والخروج
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// إدارة المتطوعين والشركات
Route::resource('volunteers', VolunteerController::class);

Route::get('/companies', [CompanyResource::class, 'index'])->name('companies.index');
Route::get('/companies/create', [CompanyResource::class, 'create'])->name('companies.create');
Route::get('/companies/{company}/edit', [CompanyResource::class, 'edit'])->name('companies.edit');
