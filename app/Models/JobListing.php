<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'title',
        'company_name',
        'company_logo',
        'location',
        'job_type',
        'level',
        'category',
        'description',
        'requirements',
        'salary_min',
        'salary_max',
        'salary_visible',
        'deadline',
        'apply_url',
        'is_active',
    ];

    protected $casts = [
        'deadline'       => 'date',
        'salary_visible' => 'boolean',
        'is_active'      => 'boolean',
    ];

    public function skills()
    {
        return $this->hasMany(JobSkill::class);
    }

    public function getJobTypeLabelAttribute(): string
    {
        return match ($this->job_type) {
            'full-time'  => 'Full-time',
            'part-time'  => 'Part-time',
            'internship' => 'Magang',
            'remote'     => 'Remote',
            'contract'   => 'Kontrak',
            default      => $this->job_type,
        };
    }

    public function getLevelLabelAttribute(): string
    {
        return match ($this->level) {
            'entry'  => 'Fresh Graduate',
            'mid'    => 'Mid-level',
            'senior' => 'Senior',
            'lead'   => 'Lead / Manager',
            default  => $this->level,
        };
    }

    public function getSalaryLabelAttribute(): string
    {
        if (! $this->salary_visible) {
            return 'Kompetitif';
        }
        if ($this->salary_min && $this->salary_max) {
            return "Rp {$this->salary_min} – Rp {$this->salary_max}";
        }
        if ($this->salary_min) {
            return "Mulai Rp {$this->salary_min}";
        }
        return 'Tidak disebutkan';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('company_name', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('category', 'like', "%{$keyword}%");
        });
    }
}
