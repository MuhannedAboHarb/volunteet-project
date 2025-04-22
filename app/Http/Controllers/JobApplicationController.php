<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Post;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    // عرض الوظائف المتاحة
    public function index()
    {
        $jobs = Post::where('status', 'مفعلة')->get();  // جلب الوظائف المفعلة فقط
        return view('job_applications.index', compact('jobs'));
    }

    // عرض نموذج التقديم على الوظيفة
    public function create($jobId)
    {
        $job = Post::findOrFail($jobId);
        return view('job_applications.create', compact('job'));
    }

    // تخزين التقديم
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cover_letter' => 'required|file|mimes:pdf,docx,doc|max:2048',
            'cv' => 'required|file|mimes:pdf,docx,doc|max:2048',
            'cover_letter_text' => 'required|string|max:1000',
        ]);

        // رفع الملفات
        $coverLetterPath = $request->file('cover_letter')->store('cover_letters');
        $cvPath = $request->file('cv')->store('cvs');

        // حفظ التقديم في قاعدة البيانات
        JobApplication::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cover_letter' => $coverLetterPath,
            'cv' => $cvPath,
            'cover_letter_text' => $request->cover_letter_text,
            'status' => 'pending',
        ]);

        return redirect()->route('job.applications.index')->with('success', 'تم تقديم الطلب بنجاح');
    }

    // عرض التقديمات
    public function show(JobApplication $jobApplication)
    {
        return view('job_applications.show', compact('jobApplication'));
    }

    public function apply($post_id)
{
    $post = Post::findOrFail($post_id); // الحصول على الوظيفة
    return view('job_applications.create', compact('post')); // عرض نموذج التقديم
}

}
