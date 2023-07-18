<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
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
}
