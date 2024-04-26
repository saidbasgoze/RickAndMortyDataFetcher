<?php
//EPISODE MODEL TESTING

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Episode;
use App\Models\Character;

class EpisodeTest extends TestCase
{
    use RefreshDatabase;

    public function testEpisodeCreationAndRelationships()
    {
        //Test if the Episodes comes correctly
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
            'image' => 'https://rickandmortyapi.com/api/character/avatar/1.jpeg'
        ]);

        $episode->characters()->attach($character->id);

        $this->assertDatabaseHas('episodes', ['name' => 'Pilot']);
        $this->assertTrue($episode->characters->contains($character));
    }
}