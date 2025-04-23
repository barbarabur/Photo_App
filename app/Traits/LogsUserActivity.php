<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogsUserActivity
{
    public function logActivity($action, $extra = [])
    {
        $userId = auth()->check() ? auth()->id() : 'guest';
        $message = "User {$userId} - Action: {$action}";

        if (!empty($extra)) {
            $message .= ' | Extra: ' . json_encode($extra);
        }

        Log::info($message);
    }
}
