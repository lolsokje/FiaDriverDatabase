<?php

use App\Models\Driver;
use App\Models\Series;
use App\Models\Team;
use Inertia\Testing\AssertableInertia;

it('sorts drivers by team name and series name on the admin page', function () {
    [$seriesA, $seriesB, $seriesC, $teamA, $teamB, $teamC] = createRequiredTestModels();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.index'))
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Drivers/Index')
            ->has('drivers', 3)
            ->has('freeAgents', 1)
            ->where('drivers.0.team_id', $teamC->id)
            ->where('drivers.0.team.series_id', $seriesA->id)
            ->where('drivers.1.team_id', $teamB->id)
            ->where('drivers.1.team.series_id', $seriesB->id)
            ->where('drivers.2.team_id', $teamA->id)
            ->where('drivers.2.team.series_id', $seriesC->id)
        );
});

it('sorts drivers by team name and series name with free agents sorted bottom on the index page', function () {
    [$seriesA, $seriesB, $seriesC, $teamA, $teamB, $teamC] = createRequiredTestModels();

    $this->get(route('index'))
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Index')
            ->has('drivers', 4)
            ->where('drivers.0.team_id', $teamC->id)
            ->where('drivers.0.team.series_id', $seriesA->id)
            ->where('drivers.1.team_id', $teamB->id)
            ->where('drivers.1.team.series_id', $seriesB->id)
            ->where('drivers.2.team_id', $teamA->id)
            ->where('drivers.2.team.series_id', $seriesC->id)
            ->where('drivers.3.team_id', null)
        );
});

function createRequiredTestModels(): array
{
    $seriesA = Series::factory()->create(['name' => 'Series A']);
    $seriesB = Series::factory()->create(['name' => 'Series B']);
    $seriesC = Series::factory()->create(['name' => 'Series C']);

    $teamA = Team::factory()->for($seriesC)->create(['name' => 'Team A']);
    $teamB = Team::factory()->for($seriesB)->create(['name' => 'Team B']);
    $teamC = Team::factory()->for($seriesA)->create(['name' => 'Team C']);

    Driver::factory()->for($teamB)->create();
    Driver::factory()->for($teamA)->create();
    Driver::factory()->for($teamC)->create();
    Driver::factory()->freeAgent()->create();

    return [$seriesA, $seriesB, $seriesC, $teamA, $teamB, $teamC];
}
