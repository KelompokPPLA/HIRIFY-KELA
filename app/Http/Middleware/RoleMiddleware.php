<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return ResponseHelper::jsonResponse(false, 'Unauthenticated.', null, 401);
        }

        if (! in_array($user->role, $roles, true)) {
            return ResponseHelper::jsonResponse(false, 'Forbidden. Role tidak memiliki akses.', null, 403);
        }

        return $next($request);
    }
}
