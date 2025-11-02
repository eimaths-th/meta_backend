<?php
// app/Helpers/LogActivity.php
namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogActivity
{
    // public static function modelEvent($model, string $action, array $before = null, array $after = null)
    public static function modelEvent($model, string $action, ?array $before = null, ?array $after = null)
    {
        ActivityLog::create([
            'user_id'      => Auth::check() ? Auth::id() : null,
            'action'       => $action,
            'description'  => "{$action}",
            'ip_address'   => Request::ip(),
            'user_agent'   => Request::header('User-Agent'),
            'model_type'   => get_class($model),
            'model_id'     => $model->id,
            'data_before'  => $before,
            'data_after'   => $after,
        ]);
    }
}
