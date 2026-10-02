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

        $route = $request->route()->getName();
        $scheduleRoute = $route === 'form.show' ? $request->route('slug') : $route;
        $times = OpeningClosingTime::currentForRoute($scheduleRoute);

        if (!$times) {
            return abort(504, 'Route times not set.');
        }

        if (!$times->isOpenAt(now())) {
            $times->update(['status' => 'Offline']);
            return abort(504, 'Route is currently closed.');
        }
        $times->update(['status' => 'Online']);

        return $next($request);
    }
}
