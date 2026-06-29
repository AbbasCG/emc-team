<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobDescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'title_ar', 'description', 'description_ar',
        'department_id', 'requirements', 'responsibilities', 'skills',
        'is_active', 'max_volunteers',
        // Extended fields
        'direct_supervisor', 'work_location', 'general_objective',
        'task_1', 'task_2', 'task_3', 'task_4',
        'education_requirements', 'years_experience', 'certifications',
        'hard_skills', 'soft_skills', 'languages', 'jd_status',
    ];

    protected function casts(): array
    {
        return [
            'requirements'     => 'array',
            'responsibilities' => 'array',
            'skills'           => 'array',
            'is_active'        => 'boolean',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'job_description_id');
    }

    public function volunteers(): HasMany
    {
        return $this->hasMany(User::class, 'job_description_id')
            ->where('role', 'volunteer');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(VolunteerApplication::class, 'job_description_id');
    }

    public function getWorkLocationLabelAttribute(): string
    {
        return match($this->work_location) {
            'remote' => 'عن بُعد',
            'onsite' => 'حضوري',
            'hybrid' => 'هجين',
            default  => '—',
        };
    }

    public function getJdStatusLabelAttribute(): string
    {
        return match($this->jd_status) {
            'active'   => 'نشط',
            'draft'    => 'مسودة',
            'archived' => 'مؤرشف',
            default    => '—',
        };
    }
}
