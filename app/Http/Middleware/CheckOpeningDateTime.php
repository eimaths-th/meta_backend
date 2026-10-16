<?php

namespace App\Http\Middleware;

use App\Models\OpeningClosingTime;
use Closure;
use Illuminate\Http\Request;

class CheckOpeningDateTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $now = now();

        $route = $request->route()->getName();
        $scheduleRoute = $route === 'form.show' ? $request->route('slug') : $route;
        $times = OpeningClosingTime::currentForRoute($scheduleRoute);

        if (!$times) {

            $status = 'Offline';
            // $times->update(['status' => $status]);
            return abort(504, 'Route times not set.');
        }

        $openingDateTime = $now->copy()->setDateTimeFrom($times->opening_time);
        $closingDateTime = $now->copy()->setDateTimeFrom($times->closing_time);

        if ($now < $openingDateTime || $now > $closingDateTime) {
            $status = 'Offline';
            $times->update(['status' => $status]);
            return abort(504, 'Route is currently closed.');
        }
        $status = 'Online';
        $times->update(['status' => $status]);

        return $next($request);
    }
}
