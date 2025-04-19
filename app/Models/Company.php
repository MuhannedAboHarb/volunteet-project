<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'industry', 'email', 'phone_number', 'website', 'logo', 'description', 'established_at'
    ];

    // العلاقة مع الوظائف التي تنشئها الشركة
    public function posts()
    {
        return $this->hasMany(Post::class);  // كل شركة يمكن أن يكون لها العديد من الوظائف
    }

    // العلاقة مع التقديمات (طلبات التوظيف)
    public function applications()
    {
        return $this->hasMany(JobApplication::class);  // كل شركة يمكن أن يكون لها العديد من التقديمات
    }

    // العلاقة مع المستخدمين (المتطوعين) الذين يعملون في الشركة
    public function users()
    {
        return $this->hasMany(User::class);  // كل شركة يمكن أن يكون لها العديد من المتطوعين (المستخدمين)
    }
    
    
}
