<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): Model;

    public function deleteById(int $id): bool;

    public function create(array $attributes): Model;

    public function update(int $id, array $attributes): Model;
}
