<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function getAll(int $limit, int $offset): LengthAwarePaginator;

    public function findBySlug(string $slug): ?Article;

    public function create(array $data): Article;

    public function update(string $slug, array $data): Article;

    public function delete(string $slug): bool;
}
