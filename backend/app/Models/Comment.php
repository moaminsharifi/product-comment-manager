<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment',
    ];

    /**
     * The comment that belong to the user.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_comment', 'comment_id', 'user_id');
    }

    /**
     * The comment that belong to the product.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_comment', 'comment_id', 'product_id');
    }
}
