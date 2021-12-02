<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $permission
     * @param string $access
     * @return mixed
     */
    public function handle($request, Closure $next, string $permission, string $access)
    {
        $user = Auth::user();

        if (!Auth::user()->hasAccess($user, $permission, $access)) {
            return response()->json(['message' => 'Forbidden Access'], 403);
        }

        return $next($request);
    }
}
