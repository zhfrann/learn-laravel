<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class RawQueryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM categories");
    }

    public function testCRUD(): void
    {
        Log::withContext(["test case" => "testCRUD"]);

        DB::insert("INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)", [
            "GADGET",
            "Gadget",
            "Gadget Category",
            "2020-10-01 10:00:05"
        ]);

        $results = DB::select("SELECT * FROM categories WHERE id = ?", ["GADGET"]);

        self::assertCount(1, $results);
        self::assertEquals("GADGET", $results[0]->id);
        self::assertEquals("Gadget", $results[0]->name);
        self::assertEquals("Gadget Category", $results[0]->description);
        self::assertEquals("2020-10-01 10:00:05", $results[0]->created_at);
    }

    public function testNamedBinding(): void
    {
        Log::withContext(["test case" => "testNamedBinding"]);

        DB::insert("INSERT INTO categories(id, name, description, created_at) VALUES(:id, :name, :desc, :created_at)", [
            "id" => "GADGET",
            "name" => "Gadget",
            "desc" => "Gadget Category",
            "created_at" => "2020-10-01 10:00:05"
        ]);

        $results = DB::select("SELECT * FROM categories WHERE id = :id", ["id" => "GADGET"]);

        self::assertCount(1, $results);
        self::assertEquals("GADGET", $results[0]->id);
        self::assertEquals("Gadget", $results[0]->name);
        self::assertEquals("Gadget Category", $results[0]->description);
        self::assertEquals("2020-10-01 10:00:05", $results[0]->created_at);
    }
}
