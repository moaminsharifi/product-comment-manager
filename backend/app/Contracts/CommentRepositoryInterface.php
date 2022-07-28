<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    public function getByComment(string $comment): Collection;
}
