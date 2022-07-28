<?php

namespace App\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getByName(string $name): Product;
}
