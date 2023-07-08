<?php

namespace App\Http\ValueObjects;

readonly class DevelopmentDriver
{
    public function __construct(
        public int $id,
        public int $rating,
        public int $dev,
        public int $newRating,
    ) {
    }
}
