<?php
//CHARACTER MODEL TESTING

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Character;
use App\Models\Location;
use App\Models\Episode;

class CharacterTest extends TestCase
{
    use RefreshDatabase;

    public function testCharacterCreationAndRelationships()
    {

        //Test if the characters comes correctly
        $location = Location::create([
            'name' => 'Earth',
            'url' => 'https://rickandmortyapi.com/api/location/1',
            'type' => 'Planet',
            'dimension' => 'C-137'
        ]);

        $episode = Episode::create([
            'name' => 'Pilot',
            'air_date' => 'December 2, 2013',
            'episode' => 'S01E01'
        ]);

        $character = Character::create([
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'species' => 'Human',
            'type' => '',
            'gender' => 'Male',
            'image' => 'https://rickandmortyapi.com/api/character/avatar/1.jpeg',
            'origin_id' => $location->id,
            'location_id' => $location->id
        ]);

        $character->episodes()->attach($episode->id);

        $this->assertDatabaseHas('characters', ['name' => 'Rick Sanchez']);
        $this->assertEquals($location->id, $character->origin->id);
        $this->assertEquals($location->id, $character->location->id);
        $this->assertTrue($character->episodes->contains($episode));
    }
}