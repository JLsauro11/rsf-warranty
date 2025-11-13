<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle($request, Closure $next, $roles)
    {
        $rolesArray = explode(',', $roles);

        if (!auth()->check() || !in_array(auth()->user()->role, $rolesArray)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }

}

