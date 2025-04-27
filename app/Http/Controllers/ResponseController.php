<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response
    {
        return response("Hello response");
    }

    public function header(Request $request): Response
    {
        $body = ["name" => "Muhammad Zhafran", "username" => "zhfran"];
        return response(json_encode($body), 200)
            ->header("Content-Type", "application/json")
            ->withHeaders([
                "Author" => "Muhammad Zhafran Ilham",
                "App" => "Belajar Laravel Dasar"
            ]);
    }

    public function responseView(Request $request): Response
    {
        return response()
            ->view("hello", ["name" => "John"]);
    }

    public function responseJson(Request $request): JsonResponse
    {
        $body = [
            "firstName" => "John",
            "lastName" => "Doe"
        ];

        return response()
            ->json($body);
    }

    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()
            ->file(storage_path('app/public/profile.jpg'));
    }

    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()
            ->download(storage_path('app/public/profile.jpg'), "Zhafran.jpg");
    }
}
