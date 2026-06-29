<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\JobDescription;
use App\Models\User;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'volunteer')
            ->with('department', 'jobDescription')
            ->when($request->search, fn ($q, $s) =>
                $q->where(fn ($sub) => $sub->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%"))
            )
            ->when($request->department_id, fn ($q, $d) => $q->where('department_id', $d))
            ->when($request->job_description_id, fn ($q, $j) => $q->where('job_description_id', $j))
            ->orderBy('created_at', 'desc');

        $volunteers = $query->paginate(20)->withQueryString();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $jobDescriptions = JobDescription::orderBy('title')->get();

        return view('admin.volunteers.index', compact('volunteers', 'departments', 'jobDescriptions'));
    }

    public function show(User $volunteer)
    {
        $volunteer->load('department', 'jobDescription');
        return view('admin.volunteers.show', compact('volunteer'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $jobDescriptions = JobDescription::orderBy('title_ar')->get();
        return view('admin.volunteers.create', compact('departments', 'jobDescriptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email',
            'password'           => 'required|string|min:8',
            'department_id'      => 'nullable|exists:departments,id',
            'job_description_id' => 'nullable|exists:job_descriptions,id',
            'phone'              => 'nullable|string|max:30',
            'city'               => 'nullable|string|max:100',
            'gender'             => 'nullable|in:male,female',
            'bio'                => 'nullable|string|max:2000',
        ]);

        $volunteer = User::create(array_merge($data, [
            'role'   => 'volunteer',
            'status' => 'active',
        ]));

        return redirect()->route('admin.volunteers.show', $volunteer)
            ->with('success', 'تم إضافة المتطوع بنجاح.');
    }

    public function edit(User $volunteer)
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        $jobDescriptions = JobDescription::orderBy('title_ar')->get();

        return view('admin.volunteers.edit', compact('volunteer', 'departments', 'jobDescriptions'));
    }

    public function update(Request $request, User $volunteer)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email,' . $volunteer->id,
            'department_id'      => 'nullable|exists:departments,id',
            'job_description_id' => 'nullable|exists:job_descriptions,id',
            'phone'              => 'nullable|string|max:30',
            'city'               => 'nullable|string|max:100',
            'gender'             => 'nullable|in:male,female',
            'bio'                => 'nullable|string|max:2000',
        ]);

        $volunteer->update($request->only(
            'name', 'email', 'department_id', 'job_description_id',
            'phone', 'city', 'gender', 'bio'
        ));

        return redirect()->route('admin.volunteers.show', $volunteer)
            ->with('success', 'تم تحديث بيانات المتطوع بنجاح.');
    }

    public function destroy(User $volunteer)
    {
        $volunteer->delete();
        return redirect()->route('admin.volunteers.index')
            ->with('success', 'تم حذف المتطوع بنجاح.');
    }
}
