<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    /**
     * return first item or create one.
     *
     * @param array $attributes
     * @return Product
     */
    public function firstOrCreate(array $attributes):Product
    {
        return Product::firstOrCreate($attributes);
    }

    /**
     * get All products.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Product::all();
    }

    /**
     * Get product by id.
     *
     * @param int $id
     * @return Product
     */
    public function getById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * Delete product by id.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        Product::destroy($id);

        return true;
    }

    /**
     * create product by attributes.
     *
     * @param array $attributes
     * @return Product
     */
    public function create(array $attributes): Product
    {
        return Product::create($attributes);
    }

    /**
     * update existent product with attributes.
     *
     * @param int $id
     * @param array $attributes
     * @return Product
     */
    public function update(int $id, array $attributes): Product
    {
        return Product::findOrFail($id)->update($attributes);
    }

    /**
     * Get product by name.
     *
     * @param string $name
     * @return Product
     */
    public function getByName(string $name): Product
    {
        return Product::where('name', $name)->first();
    }
}
