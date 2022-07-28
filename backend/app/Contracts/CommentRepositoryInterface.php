<?php
namespace App\Contracts;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Comment;
interface CommentRepositoryInterface {
    public function getByComment(string $comment): Collection;
}
