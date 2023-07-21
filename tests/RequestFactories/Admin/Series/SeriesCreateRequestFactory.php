<?php

namespace Tests\RequestFactories\Admin\Series;

use Worksome\RequestFactories\RequestFactory;

class SeriesCreateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker()->name(),
            'primary_colour' => $this->faker->safeHexColor(),
            'secondary_colour' => $this->faker->safeHexColor(),
        ];
    }
}
