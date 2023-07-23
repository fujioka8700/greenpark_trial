<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeControllerTest extends TestCase
{
  use RefreshDatabase;

  private $user, $plant;

  protected function setUp(): void
  {
    parent::setUp();

    Storage::fake('local');

    $this->seed([
      \Database\Seeders\UserSeeder::class,
      \Database\Seeders\PlantSeeder::class,
      \Database\Seeders\LikeSeeder::class,
    ]);

    $this->user = User::first();
    $this->plant = Plant::first();
  }

  public function test_この植物に対して既にlikeしたかどうかを判別する(): void
  {
    $likeExists = $this->user->isLiked($this->plant->id);

    $this->assertTrue($likeExists);
  }

  public function test_ログインユーザーのいいね状態を確認する(): void
  {
    // 「いいね」をする
    $this->user->likes()->attach($this->plant->id);

    $response = $this->actingAs($this->user)->getJson("/api/plants/{$this->plant->id}/like-status");

    $response->assertStatus(200)->assertSee('true');
  }

  public function test_既にlikeしたか確認して、もししていたら解除する(): void
  {
    $response = $this->actingAs($this->user)->postJson("/api/plants/{$this->plant->id}/unlike");

    $response->assertStatus(200)->assertSee('unlike!');

    $likeExists = $this->user->isLiked($this->plant->id);

    $this->assertFalse($likeExists);
  }

  public function test_既にlikeしたか確認したあと、いいねする（重複させない）(): void
  {
    // seeder 時点の「いいね」を解除する
    $this->user->likes()->detach($this->plant->id);

    $response = $this->actingAs($this->user)->postJson("/api/plants/{$this->plant->id}/like");

    $response->assertStatus(201)->assertSee('like!');

    $likeExists = $this->user->isLiked($this->plant->id);

    $this->assertTrue($likeExists);
  }

  public function test_1つの植物に対して、いいね合計数を返す(): void
  {
    // 1つの植物に対して、
    // 違うユーザーでいいね3回する(ここでは2回追加している)
    $users = User::factory(2)->create();
    $users->each(function ($user) {
      $user->likes()->attach($this->plant->id);
    });

    $this->assertEquals($this->plant->users->count(), 3);
  }
}
