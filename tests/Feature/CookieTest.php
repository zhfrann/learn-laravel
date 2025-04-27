<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieTest extends TestCase
{
    public function testCreateCookie()
    {
        $this->get("/cookie/set")
            ->assertCookie("User-Id", "zhafran")
            ->assertCookie("Is-Member", "true");
    }

    public function testGetCookie()
    {
        $this->withCookie("User-Id", "zhafran")
            ->withCookie("Is-Member", "true")
            ->get("/cookie/set")
            ->assertCookie("User-Id", "zhafran")
            ->assertCookie("Is-Member", "true");
    }
}
