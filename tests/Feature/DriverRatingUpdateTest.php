<?php

use App\Models\Driver;

test('an admin can update driver ratings', function () {
    [$driverOne, $driverTwo, $driverThree] = Driver::factory(3)->create(['rating' => 30]);

    $this->actingAs(createAdminUser())
        ->put(route('admin.drivers.ratings.update'), [
            'drivers' => [
                ['id' => $driverOne->id, 'rating' => 35],
                ['id' => $driverTwo->id, 'rating' => 40],
            ]
        ]);

    expect($driverOne->fresh()->rating)->toBe(35);
    expect($driverTwo->fresh()->rating)->toBe(40);
    expect($driverThree->fresh()->rating)->toBe(30);
});

test('an admin cannot update driver ratings', function () {
    [$driverOne, $driverTwo, $driverThree] = Driver::factory(3)->create(['rating' => 30]);

    $this->put(route('admin.drivers.ratings.update'), [
        'drivers' => [
            ['id' => $driverOne->id, 'rating' => 35],
            ['id' => $driverTwo->id, 'rating' => 40],
        ]
    ])
        ->assertRedirect(route('index'));

    expect($driverOne->fresh()->rating)->toBe(30);
    expect($driverTwo->fresh()->rating)->toBe(30);
    expect($driverThree->fresh()->rating)->toBe(30);
});

it('requires drivers to update their ratings', function () {
    $this->actingAs(createAdminUser())
        ->put(route('admin.drivers.ratings.update'))
        ->assertSessionHasErrors(['drivers' => 'The drivers field is required.']);
});

test('the updated driver must exist', function () {
    $this->actingAs(createAdminUser())
        ->put(route('admin.drivers.ratings.update', [
            'drivers' => [['id' => 1, 'rating' => 30]],
        ]))
        ->assertSessionHasErrors(['drivers.0.id' => 'The selected drivers.0.id is invalid.']);
});
