<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($roles === []) {
            abort(403, 'Role middleware requires at least one role.');
        }

        if (! in_array($user->role, $roles, true)) {
            abort(403, 'You are not authorized to access this area.');
        }

        return $next($request);
    }
}
