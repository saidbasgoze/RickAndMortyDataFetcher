<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use App\Console\Commands\RickAndMortyGetData;
use Mockery;
use PHPUnit\Framework\Attributes\Test;



class RickAndMortyGetDataTest extends TestCase
{
    use RefreshDatabase;

    private $mockClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockClient = Mockery::mock(Client::class);
        $this->app->instance(Client::class, $this->mockClient);
    }

    //#[Test]
    //check if the data goes(saves) to database correctly

    public function it_fetches_and_persists_data_correctly()
    {
        $this->mockClient->shouldReceive('request')
                         ->andReturnUsing(function ($method, $url) {
                             if ($url == 'https://rickandmortyapi.com/api/character') {
                                //what we expect as a result in the database
                                 return new Response(200, [], json_encode(['results' => [['id' => 1, 'name' => 'Rick Sanchez']]]));
                             } elseif (strpos($url, 'https://rickandmortyapi.com/api/episode') === 0) {
                                 return new Response(200, [], json_encode(['episode' => 'S01E01', 'name' => 'Pilot', 'air_date' => 'December 2, 2013']));
                             } else {
                                 return new Response(200, [], json_encode(['type' => 'Planet', 'dimension' => 'Dimension C-137']));
                             }
                         });

        $this->artisan('rickandmorty:getdata');

        $this->assertDatabaseHas('characters', ['name' => 'Rick Sanchez']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}