<?php
// app/Helpers/LogActivity.php
namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

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
            'user_agent'   => static::truncateUserAgent(Request::userAgent()),
            'model_type'   => get_class($model),
            'model_id'     => $model->id,
            'data_before'  => $before,
            'data_after'   => $after,
        ]);
    }

    /**
     * Keep the value within the activity_logs.user_agent VARCHAR(255) column.
     * Facebook and other in-app browsers can send User-Agent strings longer
     * than 255 characters.
     */
    protected static function truncateUserAgent(?string $userAgent): ?string
    {
        if ($userAgent === null || $userAgent === '') {
            return null;
        }

        return Str::limit($userAgent, 255, '');
    }
}
