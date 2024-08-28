<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class ArticleData extends Data
{
    public function __construct(
        #[Unique('articles', 'slug')]
        public string|Optional $slug,
        #[Min(2)]
        #[Max(255)]
        public string $title,
        #[Max(255)]
        public string $description,
        #[Max(65535)]
        public string $body,
        #[WithoutValidation]
        #[MapOutputName('createdAt')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y')]
        public Carbon|Optional $created_at,
        #[WithoutValidation]
        #[MapOutputName('updatedAt')]
        public Carbon|Optional $updated_at
    ) {}
}
