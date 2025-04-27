<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse()
    {
        $this->get("/response/hello")
            ->assertStatus(200)
            ->assertSeeText("Hello response");
    }

    public function testHeader()
    {
        $this->get("/response/header")
            ->assertStatus(200)
            ->assertSeeText("name")->assertSeeText("Muhammad Zhafran")
            ->assertSeeText("username")->assertSeeText("zhfran")
            ->assertHeader("Content-Type", "application/json")
            ->assertHeader("Author", "Muhammad Zhafran Ilham")
            ->assertHeader("App", "Belajar Laravel Dasar");
    }

    public function testView()
    {
        $this->get("/response/type/view")
            ->assertSeeText("Hello John");
    }

    public function testJson()
    {
        $this->get("/response/type/json")
            ->assertJson([
                "firstName" => "John",
                "lastName" => "Doe"
            ]);
    }

    public function testFile()
    {
        $this->get("/response/type/file")
            ->assertHeader("Content-Type", "image/jpeg");
    }

    public function testDownload()
    {
        $this->get("/response/type/download")
            ->assertDownload("Zhafran.jpg");
    }
}
