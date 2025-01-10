<?php

namespace App\Helpers;

class Difference
{
    public string $name;
    public $old;
    public $new;

    public function __construct(string $name, $old, $new)
    {
        $this->name = $name;
        $this->old = $old;
        $this->new = $new;
    }
}
