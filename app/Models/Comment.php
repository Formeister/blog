<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'body'];

    // RELATIONSHIPS

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
