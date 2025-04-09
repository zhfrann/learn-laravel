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

    public function hello(string $name = "404"): string
    {
        return $this->helloService->hello($name);
    }
}
