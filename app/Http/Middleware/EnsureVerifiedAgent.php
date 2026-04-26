<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerifiedAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->isAgent()) {
            abort(403, 'Only agents can access this area.');
        }

        if (! $user->agent || ! $user->agent->isVerified()) {
            abort(403, 'You must submit verification documents and get approved before listing properties.');
        }

        return $next($request);
    }
}
