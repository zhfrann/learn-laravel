<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get("/welcome")
            ->assertStatus(200)
            ->assertSeeText("tes routing");
    }

    public function testRedirect()
    {
        $this->get("/github")
            ->assertRedirect("https://github.com/zhfrann");
    }

    public function testFallback()
    {
        $this->get("/tidak-ada")
            ->assertSeeText("404 Tidak ada");

        $this->get("/tidak-ada-juga")
            ->assertSeeText("404 Tidak ada");
    }

    public function testView()
    {
        $this->get("/hello")
            ->assertSeeText("Hello Muh. Zhafran");

        $this->get("/hello-again")
            ->assertSeeText("Hello Muh. Zhafran");
    }

    public function testNested()
    {
        $this->get("/helloworld")
            ->assertSeeText("Hello World by Muh. Zhafran");
    }

    public function testTemplate()
    {
        $this->view("hello", ["name" => "John"])
            ->assertSeeText("Hello John");

        $this->view("hello", ["name" => "Doe"])
            ->assertSeeText("Hello Doe");
    }
}
