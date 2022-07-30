<?php

namespace App\Contracts;

interface IncrementalWarehouseInterface
{
    public function increment(string $key);

    public function get(string $key);
}
