<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    // عرض نموذج إضافة متطوع جديد
    public function create()
    {
        return view('volunteers.create');
    }

    // حفظ بيانات المتطوع الجديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:volunteers,email',
            'age' => 'required|integer|min:18|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'skills' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx',
            'has_previous_jobs' => 'required|boolean',
            'previous_jobs_details' => 'nullable|string',
            'phone_number_primary' => 'required|string',
            'phone_number_secondary' => 'nullable|string',
            'current_address' => 'required|string',
            'has_disability_or_chronic_illness' => 'required|boolean',
            'disability_or_illness_details' => 'nullable|string',
        ]);

        // حفظ البيانات
        $volunteer = Volunteer::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'skills' => $validated['skills'],
            'cv' => $request->file('cv') ? $request->file('cv')->store('volunteers/cv', 'public') : null,
            'cover_letter' => $request->file('cover_letter') ? $request->file('cover_letter')->store('volunteers/cover_letter', 'public') : null,
            'has_previous_jobs' => $validated['has_previous_jobs'],
            'previous_jobs_details' => $validated['previous_jobs_details'],
            'phone_number_primary' => $validated['phone_number_primary'],
            'phone_number_secondary' => $validated['phone_number_secondary'],
            'current_address' => $validated['current_address'],
            'has_disability_or_chronic_illness' => $validated['has_disability_or_chronic_illness'],
            'disability_or_illness_details' => $validated['disability_or_illness_details'],
        ]);

        return redirect()->route('volunteers.index')->with('success', 'Volunteer registered successfully');
    }

    // عرض الملف الشخصي للمتطوع
    public function profile()
    {
        // الحصول على التقديمات الخاصة بالمتطوع
        $jobApplications = JobApplication::where('volunteer_id', auth()->id())->get();

        // عرض الملف الشخصي مع التقديمات
        return view('volunteers.profile', compact('jobApplications'));
    }

    // تحديث الملف الشخصي
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'bio' => 'nullable|string|max:1000',
        ]);

        // تحديث بيانات المتطوع
        $volunteer = auth()->user();
        $volunteer->update($validated);
        return redirect()->route('volunteers.index')->with('success', 'volunteers created successfully');

    }
}
