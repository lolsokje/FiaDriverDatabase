<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next): RedirectResponse|Response
    {
        $user = Auth::user();

        if (! $user || ! $user->admin) {
            return to_route('index');
        }

        return $next($request);
    }
}
