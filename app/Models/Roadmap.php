<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roadmap extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'user_id',
        'career_field',
        'step_title',
        'description',
        'skills',
        'tools',
        'activities',
        'is_completed',
        'step_order',
    ];

    protected function casts(): array
    {
        return [
            'skills'       => 'array',
            'tools'        => 'array',
            'activities'   => 'array',
            'is_completed' => 'boolean',
            'step_order'   => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
