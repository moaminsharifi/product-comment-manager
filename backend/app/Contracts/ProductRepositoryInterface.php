<?php
namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
interface ProductRepositoryInterface {
    public function getByName(string $name): Product;
}