<?php

namespace App\Helpers\Global;   

use App\Models\ActivityLog;

class ActivityLogHelper
{
    public static function log($module, $action, $description)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}