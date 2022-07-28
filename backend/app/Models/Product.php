<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'creator_id',
    ];

    /**
     * The Product that belong to the user.
     */
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'product_comment', 'product_id', 'comment_id');
    }
}
