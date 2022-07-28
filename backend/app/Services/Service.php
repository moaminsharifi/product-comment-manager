<?php

namespace App\Services;

use App\Contracts\ServiceInterface;
use App\Repositories\Repository;

abstract class Service implements ServiceInterface
{
    protected $repository;


}
