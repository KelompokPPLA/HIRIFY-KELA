<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetLog extends Model
{
    protected $fillable = [
        'email',
        'token',
        'status',
        'ip_address',
        'user_agent',
        'used_at',
        'expires_at',
    ];

    protected $casts = [
        'used_at'    => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }

    public function markAsUsed(): void
    {
        $this->update([
            'status'  => 'used',
            'used_at' => now(),
        ]);
    }

    public static function markExpiredTokens(): void
    {
        static::where('status', 'requested')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
    }
}
