<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount([
            'users as volunteers_count' => fn ($q) => $q->where('role', 'volunteer'),
            'jobDescriptions',
        ])
            ->with(['jobDescriptions' => fn ($q) => $q->select('id', 'department_id', 'direct_supervisor')->whereNotNull('direct_supervisor')])
            ->orderBy('order_column')->orderBy('name')
            ->get()
            ->each(fn ($dept) => $dept->leader_name = $this->resolveLeaderName($dept));

        return view('admin.departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        $department->loadCount([
            'users as volunteers_count' => fn ($q) => $q->where('role', 'volunteer'),
            'jobDescriptions',
        ]);

        $volunteers = $department->users()
            ->where('role', 'volunteer')
            ->with('jobDescription')
            ->orderByDesc('updated_at')
            ->get();

        $leaderName = $this->resolveLeaderName($department);
        $leaderContact = $leaderName ? $this->resolveLeaderContact($department, $leaderName) : null;
        $latestVolunteer = $volunteers->first();

        return view('admin.departments.show', compact(
            'department',
            'volunteers',
            'leaderName',
            'leaderContact',
            'latestVolunteer'
        ));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'name_ar'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'color'       => 'nullable|string|max:7',
            'icon'        => 'nullable|string|max:50',
            'is_active'   => 'boolean',
        ]);

        $slug = Str::slug($data['name'] ?: $data['name_ar'] ?? 'department');
        $base = $slug; $i = 1;
        while (Department::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        Department::create(array_merge($data, ['slug' => $slug, 'is_active' => $request->boolean('is_active', true)]));

        return redirect()->route('admin.departments.index')
            ->with('success', 'تم إنشاء القسم بنجاح.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'name_ar'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'color'       => 'nullable|string|max:7',
            'icon'        => 'nullable|string|max:50',
            'is_active'   => 'boolean',
        ]);

        $department->update(array_merge($data, ['is_active' => $request->boolean('is_active')]));

        return redirect()->route('admin.departments.index')
            ->with('success', 'تم تحديث القسم بنجاح.');
    }

    public function destroy(Department $department)
    {
        if ($department->users()->where('role', 'volunteer')->exists()) {
            return back()->with('error', 'لا يمكن حذف القسم لوجود متطوعين مرتبطين به. يرجى نقلهم أولاً.');
        }

        $department->delete();
        return redirect()->route('admin.departments.index')
            ->with('success', 'تم حذف القسم بنجاح.');
    }

    private function resolveLeaderName(Department $department): ?string
    {
        $supervisors = $department->relationLoaded('jobDescriptions')
            ? $department->jobDescriptions->pluck('direct_supervisor')->filter()
            : $department->jobDescriptions()->whereNotNull('direct_supervisor')->pluck('direct_supervisor');

        if ($supervisors->isEmpty()) {
            return null;
        }

        return $supervisors->countBy()->sortDesc()->keys()->first();
    }

    private function resolveLeaderContact(Department $department, string $leaderName): ?array
    {
        $volunteer = $department->users()
            ->where('role', 'volunteer')
            ->where('name', 'like', '%' . $leaderName . '%')
            ->first();

        if (!$volunteer) {
            return null;
        }

        return [
            'email' => $volunteer->email,
            'phone' => $volunteer->phone,
        ];
    }
}
