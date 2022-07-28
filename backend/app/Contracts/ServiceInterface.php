<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ServiceInterface
{
    public function getAll(): Collection;

    public function getById(int $id): Model;

    public function deleteById(int $id): bool;
}
