<?php

namespace App\Controller;

use App\Util\Config;

abstract class Controller
{

    public function __construct(private Config $config)
    {
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

}