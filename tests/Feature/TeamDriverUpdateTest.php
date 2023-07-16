<?php

use App\Models\Driver;
use App\Models\Team;

test('an admin can update team drivers', function () {
    $team = Team::factory()->create();
    [$driverOne, $driverTwo, $driverThree] = Driver::factory(3)->for($team)->create(['rating' => 30]);
    $driverThreeId = $driverThree->driver_id;

    $this->actingAs(createAdminUser())
        ->put(route('admin.teams.drivers.update', $team), [
            'drivers' => [
                ['id' => $driverOne->id, 'rating' => 35, 'driver_id' => 'A1'],
                ['id' => $driverTwo->id, 'rating' => 40, 'driver_id' => 'A2'],
            ],
        ]);

    $driverOne->refresh();
    $driverTwo->refresh();
    $driverThree->refresh();

    $this->assertEquals(35, $driverOne->rating);
    $this->assertEquals('A1', $driverOne->driver_id);
    $this->assertEquals(40, $driverTwo->rating);
    $this->assertEquals('A2', $driverTwo->driver_id);
    $this->assertEquals(30, $driverThree->rating);
    $this->assertEquals($driverThreeId, $driverThree->driver_id);
});

test('a guest can not update team drivers', function () {
    $team = Team::factory()->create();
    [$driverOne, $driverTwo, $driverThree] = Driver::factory(3)->for($team)->create(['rating' => 30]);

    $this->put(route('admin.teams.drivers.update', $team), [
        'drivers' => [
            ['id' => $driverOne->id, 'rating' => 35],
            ['id' => $driverTwo->id, 'rating' => 40],
        ],
    ])
        ->assertRedirect(route('index'));

    $this->assertEquals(30, $driverOne->fresh()->rating);
    $this->assertEquals(30, $driverTwo->fresh()->rating);
    $this->assertEquals(30, $driverThree->fresh()->rating);
});

it('requires drivers to update their ratings', function () {
    $team = Team::factory()->create();
    $this->actingAs(createAdminUser())
        ->put(route('admin.teams.drivers.update', $team))
        ->assertSessionHasErrors(['drivers' => 'The drivers field is required.']);
});

test('the updated driver must exist', function () {
    $team = Team::factory()->create();
    $this->actingAs(createAdminUser())
        ->put(route('admin.teams.drivers.update', $team), [
            'drivers' => [['id' => 1, 'rating' => 1, 'driver_id' => 'A1']],
        ])
        ->assertSessionHasErrors(['drivers.0.id' => 'The selected drivers.0.id is invalid.']);
});
