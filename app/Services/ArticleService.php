<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\ArticleData;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator as CursorPaginatorContract;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\LazyCollection;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class ArticleService
{
    public function __construct(protected ArticleRepositoryInterface $articleRepository) {}

    public function getAll(int $limit = 20, int $offset = 0): array|DataCollection|PaginatedDataCollection|CursorPaginatedDataCollection|Enumerable|AbstractPaginator|PaginatorContract|AbstractCursorPaginator|CursorPaginatorContract|LazyCollection|Collection
    {
        $articles = $this->articleRepository->getAll($limit, $offset);

        return ArticleData::collect($articles);
    }

    public function findBySlug(string $slug): ArticleData
    {
        $article = $this->articleRepository->findBySlug($slug);

        return ArticleData::from($article);
    }

    public function create(array $data): ArticleData
    {
        $articleData = ArticleData::validate($data);
        $article     = $this->articleRepository->create($articleData);

        return ArticleData::from($article);
    }

    public function update(string $slug, array $data): ArticleData
    {
        $articleData    = ArticleData::validate($data);
        $updatedArticle = $this->articleRepository->update($slug, $articleData);

        return ArticleData::from($updatedArticle);
    }

    public function delete(string $slug): bool
    {
        return $this->articleRepository->delete($slug);
    }
}
