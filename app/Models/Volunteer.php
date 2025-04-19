<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'age',
        'gender',
        'skills',
        'cv_file',
        'cover_letter_file',
        'phone',
        'address',
        'has_disability'
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class); // متطوع ينتمي إلى مستخدم واحد
    }

    // العلاقة مع طلبات التوظيف (Job Applications)
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class); // المتطوع يمكن أن يكون له العديد من طلبات التوظيف
    }
}
