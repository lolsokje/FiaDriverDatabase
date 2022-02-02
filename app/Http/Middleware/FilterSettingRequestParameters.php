<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class FilterSettingRequestParameters
{
    protected const VALID_SETTINGS = [
        'year',
    ];

    public function handle(Request $request, Closure $next)
    {
        $filteredRequest = $request->only(self::VALID_SETTINGS);
        $request->query = new ParameterBag($filteredRequest);
        return $next($request);
    }
}
