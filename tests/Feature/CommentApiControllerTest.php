<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $user  = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $this->headers = [
            'Authorization' => 'Bearer '.$token,
        ];
    }

    public function test_it_can_list_all_comments_for_an_article(): void
    {
        $article = Article::factory()->create();

        Comment::factory()->count(5)->create(['article_id' => $article->id]);

        $response = $this->getJson(route('api.articles.comments.index', ['article' => $article->slug]), $this->headers);

        $response->assertOk()
            ->assertJsonStructure([
                'comments' => [
                    '*' => [
                        'id',
                        'body',
                        'createdAt',
                        'updatedAt',
                    ],
                ],
            ]);
    }

    public function test_it_can_create_a_comment_for_an_article(): void
    {
        $article = Article::factory()->create();

        $data = [
            'body' => 'This is a test comment.',
        ];

        $response = $this->postJson(route('api.articles.comments.store', ['article' => $article->slug]), $data, $this->headers);

        $response->assertCreated()
            ->assertJsonStructure([
                'comment' => [
                    'id',
                    'body',
                    'createdAt',
                    'updatedAt',
                ],
            ]);

        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'body'       => 'This is a test comment.',
        ]);
    }
}
