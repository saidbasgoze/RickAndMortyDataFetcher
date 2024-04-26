<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Character;
use App\Models\Location;
use App\Models\Episode;
use Carbon\Carbon;

class RickAndMortyGetData extends Command
{
    protected $signature = 'rickandmorty:getdata';  // Command signature for artisan.
    //When you write php artisan rickandmorty:getdata datas will be saved your local database
    protected $description = 'Fetches data from Rick and Morty API and stores it in the database';  // Description of what the command does.

    private $client; // GuzzleHttp Client instance.

    public function __construct()
    {
        parent::__construct();
        //This is avoiding for certificate errors
        $this->client = new Client(['verify' => false]);
    }

    public function handle()
    {
        //To check pages.
        $page = 1;
        do {
            // Request data from Rick and Morty API for the current page.
            $response = $this->client->request('GET', "https://rickandmortyapi.com/api/character?page={$page}");
            $data = json_decode($response->getBody(), true);

            foreach ($data['results'] as $item) {
                // Handle the location data for both origin and current location.
                $origin = $this->handleLocation($item['origin'] ?? null);
                $location = $this->handleLocation($item['location'] ?? null);

                // Create or update the character in the database.
                $character = Character::updateOrCreate([
                    'id' => $item['id']
                ], [
                    'name' => $item['name'] ?? 'Unknown',
                    'status' => $item['status'] ?? 'Unknown',
                    'species' => $item['species'] ?? 'Unknown',
                    'type' => $item['type'] ?? '',
                    'gender' => $item['gender'] ?? 'Unknown',
                    'image' => $item['image'] ?? '',
                    'origin_id' => $origin ? $origin->id : null,
                    'location_id' => $location ? $location->id : null,
                    'created' => Carbon::parse($item['created']) 
                ]);

                // Attach episodes to the character.
                if (!empty($item['episode'])) {
                    foreach ($item['episode'] as $episodeUrl) {
                        $episodeData = $this->fetchEpisodeData($episodeUrl);
                        if ($episodeData) {
                            $episode = Episode::firstOrCreate([
                                'episode' => $episodeData['episode'],
                                'name' => $episodeData['name'],
                                'air_date' => $episodeData['air_date'],
                                'created' => Carbon::parse($episodeData['created'])
                            ]);
                            $character->episodes()->syncWithoutDetaching([$episode->id]);
                        }
                    }
                }
            }

            // Check if there is a next page and update the page counter.
            $nextPageUrl = $data['info']['next'];
            $page = $nextPageUrl ? ++$page : null;

        } while ($page);

        // Notify the console that the data fetching and storage has been successful.
        $this->info('Rick and Morty data has been fetched and stored successfully.');
    }

    private function handleLocation($locationData)
    {
        if ($locationData && !empty($locationData['url'])) {
            // Fetch detailed information about the location.
            $details = $this->getLocationDetails($locationData['url']);
            // Create or update the location in the database.
            return Location::firstOrCreate([
                'name' => $locationData['name'],
                'url' => $locationData['url']
            ], [
                'type' => $details['type'] ?? null,
                'dimension' => $details['dimension'] ?? null,
                'created' => Carbon::parse($details['created'])
            ]);
        }
        return null;
    }

    private function fetchEpisodeData($url)
    {
        try {
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Log error if episode data fetching fails.
            \Log::error("Failed to fetch episode data from {$url}: " . $e->getMessage());
            return null;
        }
    }

    private function getLocationDetails($url)
    {
        try {
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Log error if location details fetching fails.
            \Log::error("Failed to fetch location details: " . $e->getMessage());
            return [];
        }
    }
}
