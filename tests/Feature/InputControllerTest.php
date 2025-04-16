<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get("/input/hello?name=Joko")
            ->assertSeeText("Hello Joko");

        $this->post("/input/hello", [
            "name" => "Joko"
        ])->assertSeeText("Hello Joko");
    }

    public function testNestedInput()
    {
        $this->post("/input/hello/first", [
            "name" => [
                "first" => "John",
                "last" => "Doe"
            ]
        ])->assertSeeText("Hello John");
    }

    public function testInputAll()
    {
        $this->post("/input/hello/input", [
            "name" => [
                "first" => "John",
                "last" => "Doe"
            ]
        ])->assertSeeText("name")
            ->assertSeeText("first")
            ->assertSeeText("last")
            ->assertSeeText("John")
            ->assertSeeText("Doe");
    }

    public function testArrayInput()
    {
        $this->post("/input/hello/array", [
            "products" => [
                [
                    "name" => "Apple Mac Book Pro",
                    "price" => 30_000_000
                ],
                [
                    "name" => "Samsung Galaxy S",
                    "price" => 15_000_000
                ],
            ]
        ])->assertSeeText("Apple Mac Book Pro")
            ->assertSeeText("amsung Galaxy S");
    }
}
