<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisWarehouse extends BaseWarehouse
{
    /**
     * increment.
     *
     * @param string $key
     * @return void
     */
    public function increment(string $key)
    {
        return Redis::incr("{$key}");
    }

    /**
     * get specific key.
     *
     * @param string $key
     * @return value
     */
    public function get(string $key)
    {
        return Redis::get("{$key}");
    }
}
