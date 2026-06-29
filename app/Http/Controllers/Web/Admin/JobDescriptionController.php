<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\JobDescription;
use Illuminate\Http\Request;

class JobDescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = JobDescription::with('department')
            ->withCount(['volunteers as volunteers_count'])
            ->when($request->search, fn ($q, $s) =>
                $q->where(fn ($sub) => $sub
                    ->where('title', 'like', "%$s%")
                    ->orWhere('title_ar', 'like', "%$s%")
                )
            )
            ->when($request->department_id, fn ($q, $d) => $q->where('department_id', $d));

        match ($request->input('sort', 'newest')) {
            'oldest'     => $query->orderBy('created_at', 'asc'),
            'title'      => $query->orderBy('title_ar', 'asc'),
            'volunteers' => $query->orderByDesc('volunteers_count'),
            default      => $query->orderByDesc('created_at'),
        };

        $jobDescriptions = $query->paginate(15)->withQueryString();
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('admin.job-descriptions.index', compact('jobDescriptions', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        return view('admin.job-descriptions.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                 => 'nullable|string|max:255',
            'title_ar'              => 'required|string|max:255',
            'department_id'         => 'required|exists:departments,id',
            'direct_supervisor'     => 'nullable|string|max:255',
            'work_location'         => 'nullable|in:remote,onsite,hybrid',
            'general_objective'     => 'nullable|string',
            'task_1'                => 'required|string',
            'task_2'                => 'nullable|string',
            'task_3'                => 'nullable|string',
            'task_4'                => 'nullable|string',
            'education_requirements'=> 'nullable|string|max:255',
            'years_experience'      => 'nullable|string|max:100',
            'certifications'        => 'nullable|string|max:500',
            'hard_skills'           => 'nullable|string',
            'soft_skills'           => 'nullable|string',
            'languages'             => 'nullable|string|max:255',
            'max_volunteers'        => 'nullable|integer|min:1',
        ]);

        $data['is_active'] = true;
        $data['jd_status'] = 'active';

        JobDescription::create($data);

        return redirect()->route('admin.job-descriptions.index')
            ->with('success', 'تم إنشاء بطاقة الوصف الوظيفي بنجاح.');
    }

    public function show(JobDescription $jobDescription)
    {
        $jobDescription->load([
            'department',
            'volunteers' => fn ($q) => $q->with('department')->orderByDesc('updated_at'),
        ])->loadCount('volunteers');

        $linkedVolunteers = $jobDescription->volunteers;

        return view('admin.job-descriptions.show', compact('jobDescription', 'linkedVolunteers'));
    }

    public function edit(JobDescription $jobDescription)
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        return view('admin.job-descriptions.edit', compact('jobDescription', 'departments'));
    }

    public function update(Request $request, JobDescription $jobDescription)
    {
        $data = $request->validate([
            'title'                 => 'nullable|string|max:255',
            'title_ar'              => 'required|string|max:255',
            'department_id'         => 'required|exists:departments,id',
            'direct_supervisor'     => 'nullable|string|max:255',
            'work_location'         => 'nullable|in:remote,onsite,hybrid',
            'general_objective'     => 'nullable|string',
            'task_1'                => 'required|string',
            'task_2'                => 'nullable|string',
            'task_3'                => 'nullable|string',
            'task_4'                => 'nullable|string',
            'education_requirements'=> 'nullable|string|max:255',
            'years_experience'      => 'nullable|string|max:100',
            'certifications'        => 'nullable|string|max:500',
            'hard_skills'           => 'nullable|string',
            'soft_skills'           => 'nullable|string',
            'languages'             => 'nullable|string|max:255',
            'max_volunteers'        => 'nullable|integer|min:1',
        ]);

        $data['is_active'] = true;

        $jobDescription->update($data);

        return redirect()->route('admin.job-descriptions.show', $jobDescription)
            ->with('success', 'تم تحديث بطاقة الوصف الوظيفي بنجاح.');
    }

    public function destroy(JobDescription $jobDescription)
    {
        $jobDescription->delete();
        return redirect()->route('admin.job-descriptions.index')
            ->with('success', 'تم حذف بطاقة الوصف الوظيفي بنجاح.');
    }
}
