<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'department_id',
        'job_description_id',
        'required_volunteers',
        'status',
        'deadline',
        'requirements',
        'location',
        'is_remote',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'requirements' => 'array',
            'is_remote'    => 'boolean',
            'deadline'     => 'date',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function jobDescription(): BelongsTo
    {
        return $this->belongsTo(JobDescription::class, 'job_description_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Applications submitted against this volunteer request
     * (via matching job_description_id or department_id).
     */
    public function applications(): HasMany
    {
        return $this->hasMany(VolunteerApplication::class, 'job_description_id', 'job_description_id');
    }
}
