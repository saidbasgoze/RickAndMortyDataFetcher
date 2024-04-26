<?php

//OLASI HATALARI ENGELLEME
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class LoggingTest extends TestCase
{
    public function testLoggingError()
    {
        Log::shouldReceive('error')
            ->once()
            ->with('Test error occured');
            //If error occurs write laravellog like Test error occured while testing

            Log::error('Test error occured');

    }
}