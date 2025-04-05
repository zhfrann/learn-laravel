<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig()
    {
        $firstName = config("myconfig.name.first");
        $lastName = config("myconfig.name.last");
        $email = config("myconfig.email");
        $web = config("myconfig.web");

        self::assertEquals("Muh. Zhafran", $firstName);
        self::assertEquals("Ilham", $lastName);
        self::assertEquals("muh.zhafranilham@gmail.com", $email);
        self::assertEquals("https://zhfrann.github.io/personal-web", $web);
    }
}
