<?php

namespace App\Service;

class HelloServiceIndonesia implements IHelloService
{
    function hello(string $name): string
    {
        return "Halo $name";
    }
}
