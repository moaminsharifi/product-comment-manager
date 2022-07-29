<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * comments database has expected columns test.
     * @test
     * @group Feature
     * @group Comment
     * @return void
     */
    public function comments_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('comments', [
                'id', 'comment', 'created_at', 'updated_at',
            ]),
            1
        );
    }

    /**
     * product belong to user test.
     * @test
     * @group Feature
     * @group Comment
     * @return void
     */
    public function product_belong_to_user()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['creator_id' => $user->id]);

        // check creator of user
        $this->assertInstanceOf(User::class, $product->creator);
    }
}
