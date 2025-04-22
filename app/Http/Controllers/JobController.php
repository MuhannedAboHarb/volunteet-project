<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // عرض جميع الوظائف (عادةً يتم عرض الوظائف المنشورة)
    public function index()
{
    // عرض الوظائف التي تم نشرها فقط
    $jobs = Post::where('status', 'مفعلة')->get();
    return view('jobs.index', compact('jobs'));
}


    // عرض تفاصيل الوظيفة
    public function show($id)
{
    $job = Post::findOrFail($id);  // جلب تفاصيل الوظيفة
    return view('jobs.show', compact('job'));
}

    // عرض نموذج تقديم طلب للوظيفة
    public function apply(Post $post)
    {
        return view('jobs.apply', compact('post'));  // عرض نموذج التقديم
    }
}
