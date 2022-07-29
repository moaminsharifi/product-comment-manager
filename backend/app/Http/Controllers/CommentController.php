<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Policies\CommentPolicy;
use App\Services\CommentService;
use App\Services\UserService;

class CommentController extends Controller
{
    protected $userService;
    protected $commentService;

    /**
     * Constructor function.
     *
     * @param UserService $userService
     * @param CommentService $commentService
     */
    public function __construct(UserService $userService, CommentService $commentService)
    {
        $this->userService = $userService;
        $this->commentService = $commentService;
    }

    /**
     * Store Comment.
     *
     * This endpoint Add new comment to system. If product not exist then create anonymous product.
     *
     * @authenticated
     *
     * @responseFile status=200 docs/responses/comment/store.success.json
     * @responseFile status=422 scenario="Invalid inputs"
     * @param StoreCommentRequest  $request
     * @param CommentPolicy $policy
     * @return Response
     */
    public function store(StoreCommentRequest $request, CommentPolicy $policy)
    {
        $user = auth()->user();
        $comment = $this->commentService->create($request, $user, $policy);
        return new CommentResource($comment);
    }
}
