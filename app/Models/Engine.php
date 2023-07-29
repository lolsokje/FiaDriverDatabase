<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Engine extends SnowflakeModel
{
    use HasFactory;

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }
}
