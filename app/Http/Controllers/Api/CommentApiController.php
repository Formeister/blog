<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    public function __construct(protected CommentService $commentService) {}

    public function index($slug): JsonResponse
    {
        $comments = $this->commentService->getAllForArticle($slug);

        return response()->json(['comments' => $comments]);
    }

    public function store(Request $request, $slug): JsonResponse
    {
        $comment = $this->commentService->createForArticle($slug, $request->all());

        return response()->json(['comment' => $comment], 201);
    }
}
