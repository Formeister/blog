<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\CommentData;
use App\Repositories\Interfaces\CommentRepositoryInterface;
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

class CommentService
{
    public function __construct(protected CommentRepositoryInterface $commentRepository) {}

    public function getAllForArticle(string $slug): array|DataCollection|PaginatedDataCollection|CursorPaginatedDataCollection|Enumerable|AbstractPaginator|PaginatorContract|AbstractCursorPaginator|CursorPaginatorContract|LazyCollection|Collection
    {
        $comments = $this->commentRepository->getAllForArticle($slug);

        return CommentData::collect($comments);
    }

    public function createForArticle(string $slug, array $data): CommentData
    {
        $commentData = CommentData::validate($data);
        $comment     = $this->commentRepository->createForArticle($slug, $commentData);

        return CommentData::from($comment);
    }
}
