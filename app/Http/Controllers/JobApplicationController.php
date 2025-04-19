<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Post;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    // عرض الوظائف المتاحة للمتطوعين
    public function index()
    {
        $jobs = Post::all(); // جلب جميع الوظائف
        return view('job_applications.index', compact('jobs'));
    }

    // عرض نموذج تقديم طلب وظيفة
    public function create($jobId)
    {
        $job = Post::findOrFail($jobId); // جلب الوظيفة المحددة
        return view('job_applications.create', compact('job'));
    }

    // حفظ طلب التقديم
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:posts,id',  // التأكد من أن الوظيفة موجودة
            'cover_letter' => 'required|string',    // خطاب التغطية مطلوب
        ]);

        // إنشاء طلب التقديم
        JobApplication::create([
            'user_id' => auth()->user()->id,  // ربط الطلب بالمتطوع
            'job_id' => $validated['job_id'],  // ربط التقديم بالوظيفة
            'cover_letter' => $validated['cover_letter'],  // خطاب التغطية
            'status' => 'pending',  // تعيين حالة الطلب كـ "معلق" عند التقديم
        ]);

        return redirect()->route('job-applications.index')->with('success', 'Your application has been submitted.');
    }

    // عرض التفاصيل
    public function show(JobApplication $jobApplication)
    {
        return view('job_applications.show', compact('jobApplication'));
    }
}
