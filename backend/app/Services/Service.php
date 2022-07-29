<?php

namespace App\Services;

use App\Contracts\ServiceInterface;

abstract class Service implements ServiceInterface
{
    protected $repository;
}
