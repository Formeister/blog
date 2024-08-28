<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class EloquentCommentRepository implements CommentRepositoryInterface
{
    public function getAllForArticle(string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        return $article->comments()->get();
    }

    public function createForArticle(string $slug, array $data): Comment
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        return $article->comments()->create($data);
    }
}
