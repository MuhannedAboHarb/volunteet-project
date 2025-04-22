<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'cover_letter',
        'cv',
        'cover_letter_text',
        'status',
    ];

    // علاقة مع المتطوع
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع الوظيفة
    public function job()
    {
        return $this->belongsTo(Post::class, 'job_id');
    }
}
