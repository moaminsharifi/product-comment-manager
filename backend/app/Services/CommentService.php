<?php

namespace App\Services;

use App\Helpers\CustomResponse;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Repositories\CommentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Jobs\IncrementCommentOfProductJob;
use App\Contracts\IncrementalWarehouseInterface;

class CommentService extends Service
{
    protected $userRepository;
    protected $productRepository;
    protected $commentRepository;
    protected $warehouse;
    /**
     * Constructor function.
     *
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     * @param CommentRepository $commentRepository
     * @param IncrementalWarehouseInterface $warehouse
     */
    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, CommentRepository $commentRepository, IncrementalWarehouseInterface $warehouse)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->commentRepository = $commentRepository;
        $this->warehouse = $warehouse;
    }

    /**
     * get all users.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->commentRepository->getAll();
    }

    /**
     * get user by is.
     *
     * @param int $id
     * @return Comment
     */
    public function getById(int $id): Comment
    {
        return $this->commentRepository->getById($id);
    }

    /**
     * Delete user.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->commentRepository->deleteById($id);
    }

    /**
     * Create new user.
     *
     * @param StoreCommentRequest $request
     * @param User $user
     * @param CommentPolicy $policy
     * @return Comment
     */
    public function create(StoreCommentRequest $request, User $user, CommentPolicy $policy): Comment
    {
        $request->validated();

        DB::beginTransaction();
        $attributes = $request->only(['productName', 'comment']);
        $product = $this->productRepository->firstOrCreate(['name'=>$attributes['productName']]);
        abort_unless($policy->create($user, $product), CustomResponse::createError('20002'));

        try {
            $comment = $this->commentRepository->create(['comment'=>$attributes['comment']]);
            $product->comments()->attach($comment->id);
            $user->comments()->attach($comment->id);
            dispatch(new IncrementCommentOfProductJob($product->name, $this->warehouse));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            abort(CustomResponse::createError('20001', "{$e->getMessage()}"));
        }

        return $comment;
    }
}
