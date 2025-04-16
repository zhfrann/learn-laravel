<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    public function testUpload()
    {
        $imageFake = UploadedFile::fake()->image("fakeImage.png");

        $this->post("/file/upload", [
            "picture" => $imageFake
        ])->assertSeeText("OK fakeImage.png");
    }
}
