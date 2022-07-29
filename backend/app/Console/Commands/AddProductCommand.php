<?php

namespace App\Console\Commands;

use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Console\Command;

class AddProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:product {productName} {ownerId=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New Product';

    /**
     * Execute the console command.
     *
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     * @return void
     */
    public function handle(UserRepository $userRepository, ProductRepository $productRepository)
    {
        try {
            $productName = $this->argument('productName');
            if (strlen($productName) == 0) {
                throw new Exception('length of product must be at least one');
            }

            try {
                $user = $userRepository->getById($this->argument('ownerId'));
            } catch (\Throwable $th) {
                $user = null;
            }

            $productAttributes = ['name' => $productName];
            $product = (!$user) ? $productRepository->firstOrCreate($productAttributes) : $user->products()->firstOrCreate($productAttributes);
        } catch (\Exception $e) {
            $this->error('we have error:');
            $this->error("{$e->getMessage()}");
        }
        $this->info("Product Created with ID {$product->id}");

        return 0;
    }
}
