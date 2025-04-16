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

    public function testInputType()
    {
        $this->post("/input/type", [
            "name" => "John",
            "married" => "true",
            "birth_date" => "1990-10-10"
        ])->assertSeeText("John")
            ->assertSeeText("true")
            ->assertSeeText("1990-10-10");
    }

    public function testFilterOnly()
    {
        $this->post("/input/filter/only", [
            "name" => [
                "first" => "Muhammad",
                "middle" => "Zhafran",
                "last" => "Ilham"
            ]
        ])->assertSeeText("name")
            ->assertSeeText("first")->assertSeeText("Muhammad")
            ->assertDontSeeText("middle")->assertDontSeeText("Zhafran")
            ->assertSeeText("last")->assertSeeText("Ilham");
    }

    public function testExceptOnly()
    {
        $this->post("/input/except/only", [
            "username" => "zhfran",
            "admin" => true,
            "password" => "rahasia"
        ])->assertSeeText("username")->assertSeeText("zhfran")
            ->assertDontSeeText("admin")->assertDontSeeText("true")
            ->assertSeeText("password")->assertSeeText("rahasia");
    }

    public function testFilterMerge()
    {
        $this->post("/input/filter/merge", [
            "username" => "zhfran",
            "admin" => true,
            "password" => "rahasia"
        ])->assertSeeText("username")->assertSeeText("zhfran")
            ->assertSeeText("admin")->assertSeeText("false")
            ->assertSeeText("password")->assertSeeText("rahasia");
    }
}
