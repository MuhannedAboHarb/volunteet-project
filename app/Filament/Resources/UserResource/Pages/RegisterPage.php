<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms;
use Filament\Resources\Pages\Page;
use App\Models\User;

class RegisterPage extends Page
{
    protected static string $resource = UserResource::class;
    protected static string $view = 'filament.resources.user-resource.pages.register-page';
    
    public $name, $email, $password, $password_confirmation, $role;

    public function mount(): void
    {
        $this->role = 'volunteer'; // تحديد الدور الافتراضي
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',  // تأكيد كلمة المرور
            'role' => 'required|in:volunteer,company', // التحقق من الدور
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role,
        ]);

        // إعادة التوجيه بعد التسجيل
        return redirect()->route('login');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->minLength(6),

            Forms\Components\TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->required()
                ->minLength(6),

            Forms\Components\Select::make('role')
                ->label('Choose Role')
                ->options([
                    'volunteer' => 'Volunteer',
                    'company' => 'Company',
                ])
                ->required(),
        ];
    }
}
