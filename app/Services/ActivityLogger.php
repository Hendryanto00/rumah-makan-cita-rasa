<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Create a new activity log entry in a concise, consistent way.
     */
    public static function log(string $action, string $targetTable, ?int $targetId, string $description): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'target_table' => $targetTable,
            'target_id' => $targetId,
            'description' => $description,
        ]);
    }
}


