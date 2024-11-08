<?php

namespace App\Util;

class Config
{
    public function __construct(private array $data)
    {
    }

    public function get($key): mixed
    {
        return ($this->data[$key] ?? null);
    }
}