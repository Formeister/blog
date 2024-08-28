<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Data\ArticleData;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiControllerTest extends TestCase
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

    public function test_it_can_list_all_articles(): void
    {
        Article::factory()->count(5)->create();

        $response = $this->getJson(route('api.articles.index'), $this->headers);

        $response->assertOk()
            ->assertJsonStructure([
                'articles' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'slug',
                            'title',
                            'description',
                            'body',
                            'createdAt',
                            'updatedAt',
                        ],
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links' => [
                        '*' => [
                            'url',
                            'label',
                            'active',
                        ],
                    ],
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ],
            ]);
    }

    public function test_it_can_show_a_single_article(): void
    {
        $article  = Article::factory()->create();
        $response = $this->getJson(route('api.articles.show', ['article' => $article->slug]), $this->headers);

        $response->assertOk()
            ->assertJson([
                'article' => ArticleData::from($article)->toArray(),
            ]);
    }

    public function test_it_can_create_an_article(): void
    {
        $data = [
            'title'       => 'New Article Title',
            'description' => 'New Article Description',
            'body'        => 'New Article Body',
        ];
        $response = $this->postJson(route('api.articles.store'), $data, $this->headers);

        $response->assertCreated()
            ->assertJsonStructure([
                'article' => [
                    'slug',
                    'title',
                    'description',
                    'body',
                    'createdAt',
                    'updatedAt',
                ],
            ]);

        $this->assertDatabaseHas('articles', $data);
    }

    public function test_it_can_update_an_article(): void
    {
        $article = Article::factory()->create();
        $data    = [
            'title'       => 'Updated Title',
            'description' => 'Updated Description',
            'body'        => 'Updated Body',
        ];
        $response = $this->putJson(route('api.articles.update', ['article' => $article->slug]), $data, $this->headers);

        $response->assertOk()
            ->assertJson([
                'article' => ArticleData::from($article->fresh())->toArray(),
            ]);

        $this->assertDatabaseHas('articles', $data);
    }

    public function test_it_can_delete_an_article(): void
    {
        $article  = Article::factory()->create();
        $response = $this->deleteJson(route('api.articles.destroy', ['article' => $article->slug]), [], $this->headers);

        $response->assertNoContent();

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
