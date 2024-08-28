<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentArticleRepository implements ArticleRepositoryInterface
{
    public function getAll(int $limit, int $offset): LengthAwarePaginator
    {
        return Article::latest()->paginate(perPage: $limit, page: $offset / $limit + 1);
    }

    public function findBySlug(string $slug): ?Article
    {
        return Article::where('slug', $slug)->first();
    }

    public function create(array $data): Article
    {
        return Article::create($data);
    }

    public function update(string $slug, array $data): Article
    {
        $article = $this->findBySlug($slug);

        $article->update($data);

        return $article;
    }

    public function delete(string $slug): bool
    {
        $article = $this->findBySlug($slug);

        return $article->delete();
    }
}
