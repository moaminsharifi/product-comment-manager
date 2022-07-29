<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductService extends Service
{
    /**
     * Constructor function.
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * get all users.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * get user by is.
     *
     * @param int $id
     * @return Product
     */
    public function getById(int $id): Product
    {
        return $this->repository->getById($id);
    }

    /**
     * Delete user.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->repository->deleteById($id);
    }
}
