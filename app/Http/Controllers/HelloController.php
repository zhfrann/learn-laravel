<?php

namespace App\Http\Controllers;

use App\Service\IHelloService;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    private IHelloService $helloService;

    public function __construct(IHelloService $helloService)
    {
        $this->helloService = $helloService;
    }

    public function hello(Request $request, string $name = "404"): string
    {
        return $this->helloService->hello($name);
    }

    public function request(Request $request)
    {
        return $request->path() . PHP_EOL .
            $request->url() . PHP_EOL .
            $request->fullUrl() . PHP_EOL .
            $request->method() . PHP_EOL .
            $request->header('Accept') . PHP_EOL;
    }
}
