<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlGenerationTest extends TestCase
{
    public function testCurrent()
    {
        $this->get("/url/current")
            ->assertSeeText("/url/current");

        $this->get("/url/current?name=zhafran")
            ->assertSeeText("/url/current?name=zhafran");
    }

    public function testNamed()
    {
        $this->get('/url/named')
            ->assertSeeText('/redirect/name/John');
    }

    public function testAction()
    {
        $this->get('/url/action')
            ->assertSeeText('/form');
    }
}
