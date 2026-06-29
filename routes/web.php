<?php

use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\VolunteerController;
use App\Http\Controllers\Web\Admin\DepartmentController;
use App\Http\Controllers\Web\Admin\JobDescriptionController;
use App\Http\Controllers\Web\VolunteerApplicationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Scope {volunteer} route parameter to users with role='volunteer' only
Route::bind('volunteer', function ($value) {
    return User::where('id', $value)->where('role', 'volunteer')->firstOrFail();
});

// Root → redirect to admin dashboard or login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
});

// Public volunteer application form (no auth required)
Route::get('/volunteer/apply', [VolunteerApplicationController::class, 'create'])->name('volunteer.apply');
Route::post('/volunteer/apply', [VolunteerApplicationController::class, 'store'])->name('volunteer.apply.store');
Route::get('/volunteer/apply/success', [VolunteerApplicationController::class, 'success'])->name('volunteer.apply.success');

// Admin routes — require auth + admin role
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Volunteers
    Route::get('/volunteers', [VolunteerController::class, 'index'])->name('volunteers.index');
    Route::get('/volunteers/create', [VolunteerController::class, 'create'])->name('volunteers.create');
    Route::post('/volunteers', [VolunteerController::class, 'store'])->name('volunteers.store');
    Route::get('/volunteers/{volunteer}', [VolunteerController::class, 'show'])->name('volunteers.show');
    Route::get('/volunteers/{volunteer}/edit', [VolunteerController::class, 'edit'])->name('volunteers.edit');
    Route::patch('/volunteers/{volunteer}', [VolunteerController::class, 'update'])->name('volunteers.update');
    Route::delete('/volunteers/{volunteer}', [VolunteerController::class, 'destroy'])->name('volunteers.destroy');

    // Departments
    Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
    Route::resource('departments', DepartmentController::class)->except(['show']);

    // Job Descriptions
    Route::resource('job-descriptions', JobDescriptionController::class);
});

require __DIR__.'/auth.php';
