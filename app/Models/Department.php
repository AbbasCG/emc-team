<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'name_ar',
        'slug',
        'description',
        'color',
        'icon',
        'is_active',
        'parent_id',
        'order_column',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function jobDescriptions(): HasMany
    {
        return $this->hasMany(JobDescription::class, 'department_id');
    }

    public function volunteerRequests(): HasMany
    {
        return $this->hasMany(VolunteerRequest::class, 'department_id');
    }
}
