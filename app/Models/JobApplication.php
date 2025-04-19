<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'job_id', 'cover_letter', 'status',
    ];

    // علاقة التقديم بالوظيفة
    public function job()
    {
        return $this->belongsTo(Post::class, 'job_id');
    }

    // علاقة التقديم بالمتطوع
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
