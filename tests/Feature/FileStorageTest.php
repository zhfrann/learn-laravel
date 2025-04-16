<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageTest extends TestCase
{
    public function testStorage()
    {
        $fileSystem = Storage::disk("local");
        $fileSystem->put("file.txt", "Put your content here");

        $content = $fileSystem->get("file.txt");
        self::assertEquals("Put your content here", $content);
    }

    public function testPublic()
    {
        $fileSystem = Storage::disk("public");
        $fileSystem->put("file.txt", "Muhammad Zhafran Ilham");

        $content = $fileSystem->get("file.txt");
        self::assertEquals("Muhammad Zhafran Ilham", $content);
    }
}
