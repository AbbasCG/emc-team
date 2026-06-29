<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\JobDescription;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVolunteers = User::where('role', 'volunteer')->count();
        $totalDepartments = Department::count();
        $totalJobDescriptions = JobDescription::count();

        $newThisMonth = User::where('role', 'volunteer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $departmentsWithVolunteers = Department::whereHas('users', fn ($q) => $q->where('role', 'volunteer'))->count();

        $registeredJobs = JobDescription::count();

        // Volunteers per department
        $byDepartment = Department::withCount([
            'users as volunteers_count' => fn ($q) => $q->where('role', 'volunteer'),
            'jobDescriptions',
        ])
            ->orderByDesc('volunteers_count')
            ->get();

        // Job descriptions per department (for chart)
        $jobsByDepartment = Department::withCount('jobDescriptions')
            ->having('job_descriptions_count', '>', 0)
            ->orderByDesc('job_descriptions_count')
            ->get();

        // Department coverage: % of departments with at least one volunteer
        $departmentCoverage = $totalDepartments > 0
            ? round(($departmentsWithVolunteers / $totalDepartments) * 100)
            : 0;

        // Monthly trend (last 6 months)
        $rawTrend = User::where('role', 'volunteer')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->select(DB::raw('YEAR(created_at) y'), DB::raw('MONTH(created_at) m'), DB::raw('COUNT(*) cnt'))
            ->groupBy('y', 'm')
            ->orderBy('y')->orderBy('m')
            ->get()
            ->keyBy(fn ($r) => $r->y . '-' . $r->m);

        $monthlyTrend = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key  = $date->year . '-' . $date->month;
            $monthlyTrend->push([
                'label' => $date->locale('ar')->isoFormat('MMM YY'),
                'count' => $rawTrend->has($key) ? $rawTrend[$key]->cnt : 0,
            ]);
        }

        // Recent volunteers (last 8)
        $recentVolunteers = User::where('role', 'volunteer')
            ->with(['department', 'jobDescription'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalVolunteers',
            'totalDepartments',
            'totalJobDescriptions',
            'newThisMonth',
            'departmentsWithVolunteers',
            'registeredJobs',
            'byDepartment',
            'jobsByDepartment',
            'departmentCoverage',
            'monthlyTrend',
            'recentVolunteers'
        ));
    }
}
