<?php

declare(strict_types=1);

namespace App\Data;

use DateTime;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class CommentData extends Data
{
    public function __construct(
        public string|Optional $id,
        #[Max(1000)]
        public string $body,
        #[MapOutputName('createdAt')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y H:i')]
        public DateTime|Optional $created_at,
        #[MapOutputName('updatedAt')]
        public DateTime|Optional $updated_at,
    ) {}
}
