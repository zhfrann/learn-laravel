<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloControllerTest extends TestCase
{
    public function testHello()
    {
        $this->get("/controller/hello/John")
            ->assertSeeText("Halo John");

        $this->get("/controller/hello")
            ->assertSeeText("Halo 404");
    }
}
