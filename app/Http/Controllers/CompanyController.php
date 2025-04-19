<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // عرض جميع الشركات
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    // عرض نموذج إضافة شركة جديدة
    public function create()
    {
        return view('companies.create');
    }

    // إضافة شركة جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'phone_number' => 'nullable|string',
            'website' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable|string',
            'established_at' => 'nullable|date',
        ]);

        // حفظ الشركة في قاعدة البيانات
        $company = Company::create($validated);

        // رفع الشعار إذا تم تحميله
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('companies/logos', 'public');
            $company->logo = $logoPath;
            $company->save();
        }

        return redirect()->route('companies.index')->with('success', 'Company created successfully');
    }

    // عرض تفاصيل الشركة
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    // عرض نموذج تعديل الشركة
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    // تحديث بيانات الشركة
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'phone_number' => 'nullable|string',
            'website' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable|string',
            'established_at' => 'nullable|date',
        ]);

        // تحديث الشركة في قاعدة البيانات
        $company->update($validated);

        // رفع الشعار إذا تم تحميله
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('companies/logos', 'public');
            $company->logo = $logoPath;
            $company->save();
        }

        return redirect()->route('companies.index')->with('success', 'Company updated successfully');
    }

    // حذف شركة
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully');
    }
}
