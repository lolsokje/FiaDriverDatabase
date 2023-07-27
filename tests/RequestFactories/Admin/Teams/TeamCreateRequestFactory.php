<?php

namespace Tests\RequestFactories\Admin\Teams;

use Database\Factories\TeamFactory;
use Worksome\RequestFactories\RequestFactory;

class TeamCreateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return (new TeamFactory)->definition();
    }
}
