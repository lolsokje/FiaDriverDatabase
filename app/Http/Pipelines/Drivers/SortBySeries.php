<?php

namespace App\Http\Pipelines\Drivers;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SortBySeries
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $builder
            ->with([
                'team' => [
                    'owner',
                    'series' => function (BelongsTo $query) {
                        $query->orderBy('id');
                    },
                ],
            ]);

        return $next($builder);
    }
}
