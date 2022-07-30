<?php

namespace App\Jobs;

use App\Contracts\IncrementalWarehouseInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncrementCommentOfProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $key;
    protected $warehouse;

    /**
     * Create a new job instance.
     *
     * @param string $key
     * @param IncrementalWarehouseInterface $warehouse
     */
    public function __construct(string $key, IncrementalWarehouseInterface $warehouse)
    {
        $this->key = $key;
        $this->warehouse = $warehouse;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->warehouse->increment($this->key);
    }
}
