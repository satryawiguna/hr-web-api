<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class RolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $permission
     * @return mixed
     */
    public function handle($request, Closure $next, string $permission)
    {
        $user = Auth::user();

        if (!Auth::user()->hasPermission($user, $permission)) {
            return response()->json(['message' => 'Forbidden Permission'], 403);;
        }

        return $next($request);
    }
}
