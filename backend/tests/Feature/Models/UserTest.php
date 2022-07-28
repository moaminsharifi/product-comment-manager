<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * users database has expected columns test
     * @test
     * @group Feature
     * @group User
     * @return void
     */
    public function users_database_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('users', [
                'id','name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at' , 'updated_at'
            ]), 1);
    }

    /**
     * user has product test
     * @test
     * @group Feature
     * @group User
     * @return void
     */
    public function user_has_product()
    {
        $user = User::factory()->create(); 
        $product = Product::factory()->create(['creator_id' => $user->id]); 

        // check user create product which is instance of Product
        $this->assertTrue( $user->products->contains($product)); 
        
        
        // check user has one product as creator
        $this->assertEquals(1, $user->products->count()); 

        // check user's products is collection
        $this->assertInstanceOf(Collection::class , $user->products);

    }


    /**
     * user_comment database has expected columns test
     * @test
     * @group Feature
     * @group User
     * @group Comment
     * @return void
     */
    public function user_comment_comment_database_has_expected_columns()
    {
        $this->assertTrue( 
            Schema::hasColumns('user_comment', [
                'comment_id','user_id'
            ]), 1);
    }


    /**
     * test a user has a gem
     * @test
     * @group Unit
     * @group User
     * @group Product
     * @return void
     */
    public function user_and_product_has_comment()
    {
        $user = User::factory()->create(); 
        $product = Product::factory()->create(['creator_id' => $user->id]); 
        // check user create product which is instance of Product
        $this->assertTrue( $user->products->contains($product)); 

        $comment = Comment::factory()->create();

        $product->comments()->attach($comment->id);
        $user->comments()->attach($comment->id);
      
        $this->assertTrue( $user->comments->contains($comment)); 
        $this->assertTrue( $product->comments->contains($comment)); 
       



        

    }



}
