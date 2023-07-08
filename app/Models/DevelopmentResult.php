<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevelopmentResult extends SnowflakeModel
{
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }
}
