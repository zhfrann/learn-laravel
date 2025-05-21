<?php

namespace Tests\Feature;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM categories");
    }

    public function testTransactionSuccess(): void
    {
        Log::withContext(["test case" => "testTransactionSuccess"]);

        DB::transaction(function () {
            DB::insert(
                "INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)",
                ["GADGET", "Gadget", "Gadget Category", "2020-10-01 10:00:05"]
            );

            DB::insert(
                "INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)",
                ["FOOD", "Food", "Food Category", "2020-10-01 10:00:23"]
            );
        }, 1);

        $result = DB::select("SELECT * FROM categories");
        self::assertCount(2, $result);
    }

    public function testTransactionFailed(): void
    {
        Log::withContext(["test case" => "testTransactionFailed"]);

        try {
            DB::transaction(function () {
                DB::insert(
                    "INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)",
                    ["GADGET", "Gadget", "Gadget Category", "2020-10-01 10:00:05"]
                );

                DB::insert(
                    "INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)",
                    ["GADGET", "Gadget", "Gadget Category", "2020-10-01 10:00:05"]
                );
            }, 1);
        } catch (QueryException $e) {
            // throw $e;
        }

        $result = DB::select("SELECT * FROM categories");
        self::assertCount(0, $result);
    }

    public function testManualTransactionSuccess(): void
    {
        Log::withContext(["test case" => "testManualTransactionSuccess"]);

        try {
            DB::beginTransaction();

            DB::insert(
                "INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)",
                ["GADGET", "Gadget", "Gadget Category", "2020-10-01 10:00:05"]
            );

            DB::insert(
                "INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)",
                ["FOOD", "Food", "Food Category", "2020-10-01 10:00:23"]
            );

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            // throw $e;
        }

        $result = DB::select("SELECT * FROM categories");
        self::assertCount(2, $result);
    }

    public function testManualTransactionFailed(): void
    {
        Log::withContext(["test case" => "testManualTransactionFailed"]);

        try {
            DB::beginTransaction();

            DB::insert(
                "INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)",
                ["GADGET", "Gadget", "Gadget Category", "2020-10-01 10:00:05"]
            );

            DB::insert(
                "INSERT INTO categories(id, name, description, created_at) VALUES(?, ?, ?, ?)",
                ["GADGET", "Gadget", "Gadget Category", "2020-10-01 10:00:05"]
            );

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            // throw $e;
        }

        $result = DB::select("SELECT * FROM categories");
        self::assertCount(0, $result);
    }
}
