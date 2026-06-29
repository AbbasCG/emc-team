<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\JobDescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VolunteerApplicationController extends Controller
{
    public function create()
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        return view('volunteer.apply', compact('departments'));
    }

    public function store(Request $request)
    {
        $existingUser = User::where('email', $request->input('email'))
            ->where('role', 'volunteer')
            ->first();

        $emailRule = $existingUser ? 'required|email' : 'required|email|unique:users,email';

        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => $emailRule,
            'phone'                  => 'required|string|max:30',
            'department_id'          => 'required|exists:departments,id',
            'title_ar'               => 'required|string|max:255',
            'direct_supervisor'      => 'nullable|string|max:255',
            'work_location'          => 'required|in:onsite,remote,hybrid',
            'general_objective'      => 'nullable|string|max:2000',
            'task_1'                 => 'required|string|max:1000',
            'task_2'                 => 'nullable|string|max:1000',
            'task_3'                 => 'nullable|string|max:1000',
            'task_4'                 => 'nullable|string|max:1000',
            'education_requirements' => 'nullable|string|max:500',
            'years_experience'       => 'nullable|string|max:100',
            'certifications'         => 'nullable|string|max:500',
            'hard_skills'            => 'nullable|string|max:2000',
            'soft_skills'            => 'nullable|string|max:2000',
            'languages'              => 'nullable|string|max:500',
        ], [
            'name.required'          => 'الاسم الكامل مطلوب.',
            'email.required'         => 'البريد الإلكتروني مطلوب.',
            'email.unique'           => 'هذا البريد الإلكتروني مسجّل بحساب آخر غير تطوعي.',
            'phone.required'         => 'رقم الهاتف مطلوب.',
            'department_id.required' => 'يرجى اختيار القسم.',
            'title_ar.required'      => 'المسمى الوظيفي مطلوب.',
            'work_location.required' => 'يرجى تحديد مكان العمل.',
            'task_1.required'        => 'المهمة الأساسية مطلوبة.',
        ]);

        $jdData = [
            'title_ar'               => $data['title_ar'],
            'title'                  => $data['title_ar'],
            'department_id'          => $data['department_id'],
            'direct_supervisor'      => $data['direct_supervisor'] ?? null,
            'work_location'          => $data['work_location'],
            'general_objective'      => $data['general_objective'] ?? null,
            'task_1'                 => $data['task_1'],
            'task_2'                 => $data['task_2'] ?? null,
            'task_3'                 => $data['task_3'] ?? null,
            'task_4'                 => $data['task_4'] ?? null,
            'education_requirements' => $data['education_requirements'] ?? null,
            'years_experience'       => $data['years_experience'] ?? null,
            'certifications'         => $data['certifications'] ?? null,
            'hard_skills'            => $data['hard_skills'] ?? null,
            'soft_skills'            => $data['soft_skills'] ?? null,
            'languages'              => $data['languages'] ?? null,
            'jd_status'              => 'active',
            'is_active'              => true,
        ];

        if ($existingUser) {
            if ($existingUser->job_description_id) {
                $existingUser->jobDescription()->update($jdData);
                $jd = $existingUser->jobDescription;
            } else {
                $jd = JobDescription::create($jdData);
            }

            $existingUser->update([
                'name'               => $data['name'],
                'phone'              => $data['phone'],
                'department_id'      => $data['department_id'],
                'job_description_id' => $jd->id,
                'status'             => 'active',
            ]);
        } else {
            $jd = JobDescription::create($jdData);

            User::create([
                'name'               => $data['name'],
                'email'              => $data['email'],
                'phone'              => $data['phone'],
                'password'           => Hash::make(Str::random(16)),
                'role'               => 'volunteer',
                'status'             => 'active',
                'department_id'      => $data['department_id'],
                'job_description_id' => $jd->id,
            ]);
        }

        return redirect()->route('volunteer.apply.success');
    }

    public function success()
    {
        return view('volunteer.success');
    }
}
