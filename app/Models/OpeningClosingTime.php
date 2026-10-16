<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $user_id
 * @property string $status
 * @property string $comments
 * @property string $route
 * @property string $opening_time
 * @property string $closing_time
 * @property string $created_at
 * @property string $updated_at
 */
class OpeningClosingTime extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id','status','comments','route','opening_time', 'closing_time', 'created_at', 'updated_at'];

    public static function currentForRoute(?string $route): ?self
    {
        if (blank($route)) {
            return null;
        }

        // Match the schedule selected by Forms Control, including imported history.
        return static::where('route', $route)->orderByDesc('id')->first();
    }

    public static function registrationDateForRoute(?string $route): string
    {
        $schedule = static::currentForRoute($route);

        if (! $schedule || ! $schedule->opening_time || ! $schedule->closing_time) {
            return 'Registration schedule unavailable';
        }

        // Preview must show the saved dates even before opening or after closing.
        $opening = new \DateTime($schedule->opening_time);
        $closing = new \DateTime($schedule->closing_time);

        return $opening->format('d F Y').' - '.$closing->format('d F Y');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
