<?php

namespace App\Providers;

use App\Contracts\IncrementalWarehouseInterface;
use App\Services\JsonWarehouse;
use App\Services\KeyValueYMLStyleWarehouse;
use App\Services\RedisWarehouse;
use Illuminate\Support\ServiceProvider;

class WarehouseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (config('warehouse.default') == 'yml') {
            $this->app->bind(IncrementalWarehouseInterface::class, KeyValueYMLStyleWarehouse::class);
        } elseif (config('warehouse.default') == 'json') {
            $this->app->bind(IncrementalWarehouseInterface::class, JsonWarehouse::class);
        } elseif (config('warehouse.default') == 'redis') {
            $this->app->bind(IncrementalWarehouseInterface::class, RedisWarehouse::class);
        } else {
            $this->app->bind(IncrementalWarehouseInterface::class, KeyValueYMLStyleWarehouse::class);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
