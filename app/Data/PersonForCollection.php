<?php

namespace App\Data;

class PersonForCollection
{
    var string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
