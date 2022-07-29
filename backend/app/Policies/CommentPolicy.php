<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

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
        $userCommentOnProductCount = $user->comments()->where('product_id', $product->id)->count();

        return ($userCommentOnProductCount < 2) ? true : false;
    }
}
