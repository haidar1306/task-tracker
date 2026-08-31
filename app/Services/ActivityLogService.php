<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public function log($module, $action, $description)
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'module'      => $module,
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
}