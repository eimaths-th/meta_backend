<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCanManageForms
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user()?->canManageForms(), 403, 'You do not have permission to manage forms.');

        return $next($request);
    }
}
