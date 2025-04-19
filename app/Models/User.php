<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password',    
    ];

     protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // العلاقة مع التقديمات (طلبات التوظيف)
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

// داخل موديل User
public function company()
{
    return $this->belongsTo(Company::class);
}

public function posts()
{
    return $this->hasMany(Post::class);  // ربط المستخدم بالوظائف التي أنشأها
}

public function volunteer()
{
    return $this->hasOne(Volunteer::class);  // كل مستخدم يمكن أن يكون له متطوع واحد
}



}
