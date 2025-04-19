<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Post;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // عرض جميع الطلبات
    public function index()
    {
        $applications = Application::all();
        return view('applications.index', compact('applications'));
    }

    // عرض نموذج تقديم طلب
    public function create($jobId)
    {
        $job = Post::findOrFail($jobId);
        return view('applications.create', compact('job'));
    }

    // حفظ طلب التقديم
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:posts,id',
            'cover_letter' => 'required|string',
        ]);

        // حفظ التقديم في قاعدة البيانات
        Application::create([
            'user_id' => auth()->user()->id,
            'job_id' => $validated['job_id'],
            'cover_letter' => $validated['cover_letter'],
            'status' => 'pending',  // حالة الطلب عند التقديم
        ]);

        return redirect()->route('applications.index')->with('success', 'Your application has been submitted.');
    }

    // تحديث حالة الطلب
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
            'interview_date' => 'nullable|date',
            'reason_for_rejection' => 'nullable|string',
        ]);

        $application = Application::findOrFail($id);
        $application->update($validated);

        return redirect()->route('applications.index')->with('success', 'Application status updated successfully');
    }

    // عرض تفاصيل الطلب
    public function show($id)
    {
        $application = Application::findOrFail($id);
        return view('applications.show', compact('application'));
    }
}
