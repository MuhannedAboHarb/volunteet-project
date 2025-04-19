<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // عرض جميع الوظائف (عادةً يتم عرض الوظائف المنشورة)
    public function index()
    {
        $posts = Post::all(); // أو يمكنك إضافة تصفية لتصفية الوظائف حسب الشركة أو المتطوع
        return view('jobs.index', compact('posts'));
    }

    // عرض تفاصيل الوظيفة
    public function show(Post $post)
    {
        return view('jobs.show', compact('post'));  // عرض تفاصيل الوظيفة
    }

    // عرض نموذج تقديم طلب للوظيفة
    public function apply(Post $post)
    {
        return view('jobs.apply', compact('post'));  // عرض نموذج التقديم
    }
}
