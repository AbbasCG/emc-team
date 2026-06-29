<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolunteerApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'job_description_id',
        'department_id',
        'status',
        'motivation',
        'experience',
        'availability',
        'notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'availability' => 'array',
            'reviewed_at'  => 'datetime',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobDescription(): BelongsTo
    {
        return $this->belongsTo(JobDescription::class, 'job_description_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
