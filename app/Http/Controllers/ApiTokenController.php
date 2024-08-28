<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class ApiTokenController extends Controller
{
    public function __invoke(string $tokenName): array
    {
        $user  = auth()->user();
        $token = $user->createToken($tokenName);

        return ['token' => $token->plainTextToken];
    }
}
