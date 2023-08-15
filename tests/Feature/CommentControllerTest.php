<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private $user, $plant;

  protected function setUp(): void
  {
    parent::setUp();

    Storage::fake('local');

    $this->seed([
      \Database\Seeders\UserSeeder::class,
      \Database\Seeders\PlantSeeder::class
    ]);

    $this->user = User::first();
    $this->plant = Plant::first();
  }

  public function test_コメントを1つ書き込む(): void
  {
    $comment = $this->faker()->realText(100);

    $response = $this->actingAs($this->user)->postJson('/api/comments', [
      'comment' => $comment,
      'user_id' => $this->user->id,
      'plant_id' => $this->plant->id,
    ]);

    $response->assertStatus(201)->assertJson([
      'comment' => $comment,
      'user_id' => $this->user->id,
      'plant_id' => $this->plant->id,
    ]);
  }

  public function test_植物1つのコメント一覧を取得する(): void
  {
    $comment = Comment::factory()->create();
    $user = User::find($comment->user_id);

    $response = $this->getJson(route(
      'comments.index',
      ['plant_id' => $comment->plant_id],
    ));

    $response->assertStatus(200)->assertJson([
      [
        'id' => $comment->id,
        'comment' => $comment->comment,
        'user' => [
          'name' => $user->name,
        ],
      ],
    ]);
  }

  public function test_コメントを1つ削除する(): void
  {
    $createComment = 3;
    $expectedComment = $createComment - 1;

    // コメント1,2,3 (User1, 植物1 と紐付け) 作成
    Comment::factory($createComment)
      ->for($this->user)
      ->for($this->plant)
      ->create();

    $deleteComment = Comment::find(2);

    $response = $this->actingAs($this->user)
      ->deleteJson("/api/comments/{$deleteComment->id}");

    $response->assertOk()->assertSee(1);

    $this->assertEquals(Comment::count(), $expectedComment);
  }
}
