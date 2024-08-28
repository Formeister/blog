<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class ArticleIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limit' => 'sometimes|integer|min:1|max:100',
            'offset' => 'sometimes|integer|min:0',
        ];
    }

    #[Override]
    public function validated($key = null, $default = null): array
    {
        $validatedData = parent::validated();

        return [
            'limit'  => (int) ($validatedData['limit'] ?? 20), // Default to 20 if not provided
            'offset' => (int) ($validatedData['offset'] ?? 0), // Default to 0 if not provided
        ];
    }
}
