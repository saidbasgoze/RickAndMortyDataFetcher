<?php
//LOCATION MODEL TESTING

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Location;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    //Test if the Locations comes correctly
    public function testLocationCreation()
    {
        $location = Location::create([
            'name' => 'Earth',
            'url' => 'https://rickandmortyapi.com/api/location/1',
            'type' => 'Planet',
            'dimension' => 'C-137'
        ]);

        $this->assertDatabaseHas('locations', ['name' => 'Earth']);
    }
}