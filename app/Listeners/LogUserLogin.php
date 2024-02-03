<?php
// app/Listeners/LogUserLogin.php

namespace App\Listeners;

use App\Events\UserAuthenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;


class LogUserLogin implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserAuthenticated $event)
    {
        $user = $event->user;
        // Log the login time in the user's record or log table
        $user->update(['last_login_at' => now()]);
    }
}

