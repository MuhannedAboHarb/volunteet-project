<?php

namespace App\Filament\Pages;

use App\Models\JobApplication;
use App\Models\Post;
use Filament\Pages\Page;

class ApplyJob extends Page
{
    public $post;
    public $user_id;

    // تمهيد الصفحة مع البيانات المناسبة
    public function mount($post_id)
    {
        $this->post = Post::findOrFail($post_id);
        $this->user_id = auth()->id(); // الحصول على معرف المستخدم المتصل
    }

    // وظيفة تقديم التقديم على الوظيفة
    public function submitApplication()
    {
        JobApplication::create([
            'user_id' => $this->user_id,
            'post_id' => $this->post->id,
            'status' => 'pending', // حالة التقديم (معلق)
        ]);

        session()->flash('message', 'تم تقديم الطلب بنجاح.');

        return redirect()->route('job.applications'); // إعادة التوجيه إلى قائمة التقديمات
    }
}
