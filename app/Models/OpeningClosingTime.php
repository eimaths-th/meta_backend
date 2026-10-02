<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->latest()->orderByDesc('id');
    }

    public static function currentForRoute(?string $route): ?self
    {
        if (blank($route)) {
            return null;
        }

        return static::where('route', $route)->latestFirst()->first();
    }

    public function isOpenAt(CarbonInterface $time): bool
    {
        return $this->opening_time && $this->closing_time
            && $time->gte(Carbon::parse($this->opening_time))
            && $time->lte(Carbon::parse($this->closing_time));
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
