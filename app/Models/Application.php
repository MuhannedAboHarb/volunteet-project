<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'job_id', 'status', 'cover_letter', 'interview_date', 'reason_for_rejection',
    ];

    // العلاقة بين التقديم والوظيفة
    public function job()
    {
        return $this->belongsTo(Post::class, 'job_id');
    }

    // العلاقة بين التقديم والمتطوع
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
