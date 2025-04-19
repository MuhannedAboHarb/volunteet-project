<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

        // الحقول الموجودة في قاعدة البيانات
        protected $fillable = [
            'title', 'slug', 'description', 'salary', 
            'contract_details', 'location', 'company_id',
            'paid', 'posted_at', 'expires_at'
        ];
    
        protected $dates = ['posted_at', 'expires_at'];
    
        // حقول افتراضية (غير موجودة في DB)
        protected $appends = ['remote_work', 'contract_type'];
    
        // دالة لحساب عمل عن بعد (يمكن تعديل الشرط حسب احتياجك)
        public function getRemoteWorkAttribute()
        {
            return str_contains(strtolower($this->location), 'remote') || 
                   str_contains(strtolower($this->location), 'عن بعد');
        }
    
        // دالة لتحديد نوع العقد (افتراضي)
        public function getContractTypeAttribute()
        {
            return $this->salary > 5000 ? 'دوام كامل' : 'دوام جزئي';
        }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });

        static::updating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}