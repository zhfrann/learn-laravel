<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LoggingTest extends TestCase
{
    public function testLogging()
    {
        Log::info("Hello with level Info");
        Log::warning("Hello with level Warning");
        Log::error("Hello with level Error");
        Log::critical("Hello with level Critical");

        self::assertTrue(true);
    }

    public function testLoggingContext()
    {
        Log::info("Hello with level Info with Context", ["name" => "john"]);
        Log::warning("Hello with level Warning with Context", ["name" => "john"]);
        Log::critical("Hello with level Critical with Context", ["name" => "john"]);

        self::assertTrue(true);
    }

    public function testLoggingWithContext()
    {
        Log::withContext(["name" => "John"]);

        Log::info("Hello with level Info with Context");
        Log::warning("Hello with level Warning with Context");
        Log::critical("Hello with level Critical with Context");

        self::assertTrue(true);
    }

    public function testLoggingWithSelectedChannel()
    {
        $stderrLogger = Log::channel('stderr');

        $stderrLogger->error("This is error log message from stderr channel");

        Log::warning("This is warning log message from default channel");

        self::assertTrue(true);
    }

    public function testLoggingWithFileHandler()
    {
        $fileLogger = Log::channel('file');
        $fileLogger->info("Info log message from file channel (This should appear in logs/application.log)");
        $fileLogger->warning("Warning log message from file channel (This should appear in logs/application.log)");

        Log::info("Info log message from default (stack) channel");
        Log::warning("Warning log message from default (stack) channel");

        self::assertTrue(true);
    }
}
