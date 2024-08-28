<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleIndexRequest;
use App\Http\Requests\ArticleStoreRequest;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleApiController extends Controller
{
    public function __construct(protected ArticleService $articleService) {}

    public function index(ArticleIndexRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $limit         = $validatedData['limit'];
        $offset        = $validatedData['offset'];
        $articles      = $this->articleService->getAll($limit, $offset);

        return response()->json(['articles' => $articles]);
    }

    public function show($slug): JsonResponse
    {
        $article = $this->articleService->findBySlug($slug);

        return response()->json(['article' => $article]);
    }

    public function store(ArticleStoreRequest $request): JsonResponse
    {
        $article = $this->articleService->create($request->all());

        return response()->json(['article' => $article], 201);
    }

    public function update(Request $request, $slug): JsonResponse
    {
        $article = $this->articleService->update($slug, $request->all());

        return response()->json(['article' => $article]);
    }

    public function destroy($slug): Response
    {
        $this->articleService->delete($slug);

        return response()->noContent();
    }
}
