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

    public function testRouteParameter()
    {
        $this->get("/products/1")
            ->assertSeeText("Products : 1");

        $this->get("/products/2")
            ->assertSeeText("Products : 2");

        $this->get("/products/1/items/XXX")
            ->assertSeeText("Products : 1, Items : XXX");

        $this->get("/products/1/items/YYY")
            ->assertSeeText("Products : 1, Items : YYY");

        $this->get("/products/2/items/YYY")
            ->assertSeeText("Products : 2, Items : YYY");
    }

    public function testRouteParameterRegex()
    {
        $this->get("/categories/100")
            ->assertSeeText("Category : 100");

        $this->get("/categories/salah")
            ->assertSeeText("404 Tidak ada");
    }

    public function testRouteParamaterOptional()
    {
        $this->get("/users/khannedy")
            ->assertSeeText("User : khannedy");

        $this->get("/users")
            ->assertSeeText("User : 404");
    }

    public function testRouteParamaterConflict()
    {
        $this->get("/conflict/budi")
            ->assertSeeText("Conflict budi");

        $this->get("/conflict/john")
            ->assertSeeText("Conflict john");  //not "Conflict John Doe", because Laravel prioritize the first route defined that has a conflict
    }
}
