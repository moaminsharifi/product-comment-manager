<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
class ProductTest extends TestCase
{
    /**
     * products database has expected columns test
     * @test
     * @group Feature
     * @group Product
     * @return void
     */
    public function products_database_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('products', [
                'id','name',  'created_at' , 'updated_at'
            ]), 1);
    }


    /**
     * product_comment database has expected columns test
     * @test
     * @group Feature
     * @group Product
     * @group Comment
     * @return void
     */
    public function product_comment_database_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('product_comment', [
                'product_id','comment_id'
            ]), 1);
    }

}
