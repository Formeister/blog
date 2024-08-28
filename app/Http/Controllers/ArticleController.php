<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ArticleIndexRequest;
use App\Http\Requests\ArticleStoreRequest;
use App\Services\ArticleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function __construct(protected ArticleService $articleService) {}

    public function index(ArticleIndexRequest $request): Response
    {
        $validatedData = $request->validated();
        $limit         = $validatedData['limit'];
        $offset        = $validatedData['offset'];
        $articles      = $this->articleService->getAll($limit, $offset);

        return Inertia::render('Articles/Index', [
            'articles' => $articles,
        ]);
    }

    public function show(string $slug): Response
    {
        $article = $this->articleService->findBySlug($slug);

        return Inertia::render('Articles/Show', [
            'article' => $article,
        ]);
    }

    public function store(ArticleStoreRequest $request): RedirectResponse
    {
        $this->articleService->create($request->all());

        return Redirect::route('articles.index');
    }

    public function create(): Response
    {
        return Inertia::render('Articles/Create');
    }

    public function edit(string $slug): Response
    {
        $article = $this->articleService->findBySlug($slug);

        return Inertia::render('Articles/Edit', [
            'article' => $article,
        ]);
    }

    public function update(Request $request, $slug): RedirectResponse
    {
        $article = $this->articleService->update($slug, $request->all());

        return Redirect::route('articles.show', $article->slug);
    }

    public function destroy($slug): RedirectResponse
    {
        $deleted = $this->articleService->delete($slug);
        $message = $deleted
            ? ['success' => 'Article deleted successfully.']
            : ['error' => 'Failed to delete the article.'];

        return redirect()->route('articles.index')->with($message);
    }
}
