<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppEnvironmentTest extends TestCase
{
    public function testAppEnv()
    {
        if (App::environment("testing")) {
            echo "LOGIC IN TESTING ENV" . PHP_EOL;
            self::assertTrue(true);
        }
    }
}
