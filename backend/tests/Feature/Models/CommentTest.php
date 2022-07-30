<?php

namespace Tests\Feature\Models;

use App\Events\CommentCreatedEvent;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use App\Jobs\IncrementCommentOfProductJob;
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

}
