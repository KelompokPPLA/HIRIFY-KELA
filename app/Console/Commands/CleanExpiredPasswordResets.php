<?php

namespace App\Console\Commands;

use App\Models\PasswordResetLog;
use Illuminate\Console\Command;

class CleanExpiredPasswordResets extends Command
{
    protected $signature   = 'password-reset:clean';
    protected $description = 'Tandai token reset password yang sudah kadaluarsa sebagai expired';

    public function handle(): void
    {
        $count = PasswordResetLog::where('status', 'requested')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        $this->info("Berhasil menandai {$count} token reset password sebagai expired.");
    }
}
