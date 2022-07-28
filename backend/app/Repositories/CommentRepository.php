<?php

namespace App\Repositories;

use App\Contracts\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository extends Repository implements CommentRepositoryInterface
{
    /**
     * get All products.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Comment::all();
    }

    /**
     * Get product by id.
     *
     * @param int $id
     * @return Comment
     */
    public function getById(int $id): Comment
    {
        return Comment::findOrFail($id);
    }

    /**
     * Delete product by id.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        Comment::destroy($id);

        return true;
    }

    /**
     * create product by attributes.
     *
     * @param array $attributes
     * @return Comment
     */
    public function create(array $attributes): Comment
    {
        return Comment::create($attributes);
    }

    /**
     * update existent product with attributes.
     *
     * @param int $id
     * @param array $attributes
     * @return Comment
     */
    public function update(int $id, array $attributes): Comment
    {
        return Comment::findOrFail($id)->update($attributes);
    }

    /**
     * Get product by comment.
     *
     * @param string $comment
     * @return Comment
     */
    public function getByComment(string $comment): Collection
    {
        return Comment::where('comment', $comment)->orWhere('comment', 'like', '%' . $comment . '%')->get();
    }
}
