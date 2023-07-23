<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next): RedirectResponse|Response|JsonResponse
    {
        $user = Auth::user();

        if (! $user || ! $user->admin) {
            return to_route('index');
        }

        return $next($request);
    }
}
