<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    public function testGetEnvironment()
    {
        $appName = env("APP_NAME");
        self::assertNotNull($appName);
        self::assertEquals($appName, "Belajar-laravel-dasar");
    }
}
