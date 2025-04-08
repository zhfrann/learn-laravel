<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadesTest extends TestCase
{
    public function testConfig()
    {
        $firstName1 = config("myconfig.author.first");
        $firstName2 = Config::get("myconfig.author.first");

        self::assertEquals($firstName1, $firstName2);
    }

    public function testConfigDependency()
    {
        $config = $this->app->make("config");
        $firstName1 = $config->get("myconfig.author.first");
        $firstName2 = config("myconfig.author.first");
        $firstName3 = Config::get("myconfig.author.first");

        self::assertEquals($firstName1, $firstName2);
        self::assertEquals($firstName1, $firstName3);
    }

    public function testFacadeMock()
    {
        Config::shouldReceive("get")->with("myconfig.author.first")->andReturn("Budiono Siregar");

        $firstName = Config::get("myconfig.author.first");
        self::assertEquals("Budiono Siregar", $firstName);
    }
}
