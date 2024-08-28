<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function getAllForArticle(string $slug);

    public function createForArticle(string $slug, array $data): Comment;
}
