<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Custom Policy
 * Not follow default laravel Policy style.
 */
class CommentPolicy
{
    /**
     * Determine if the given comment can be to product  by the user.
     *
     * @param  User  $user
     * @param  Product  $product
     * @return bool
     */
    public function create(User $user, Product $product)
    {
        $userCommentOnProductCount = DB::table('comments')
                ->join('user_comment', 'comments.id', '=', 'user_comment.comment_id')
                ->join('product_comment', 'comments.id', '=', 'product_comment.comment_id')
                ->where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->count();

        return ($userCommentOnProductCount < 2) ? true : false;
    }
}
