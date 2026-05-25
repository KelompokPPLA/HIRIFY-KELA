<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory, UUID;

    protected $table = 'portofolios';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'file_size',
        'link',
        'skills',
        'start_date',
        'end_date',
        'is_ongoing',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_ongoing' => 'boolean',
    ];

    /**
     * Get the user that owns the portfolio item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
