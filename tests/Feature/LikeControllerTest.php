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

  public function test_既にlikeしたか確認して、もししていたら解除する(): void
  {
    $response = $this->actingAs($this->user)->postJson("/api/plants/{$this->plant->id}/unlike");

    $response->assertStatus(200)->assertSee('unlike!');

    $likeExists = $this->user->isLiked($this->plant->id);

    $this->assertFalse($likeExists);
  }
}
