<?php

namespace Tests\Feature;

use App\Models\Plant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchByPlantColorsTest extends TestCase
{
  use RefreshDatabase;

  private $user;

  protected function setUp(): void
  {
    parent::setUp();

    \Illuminate\Support\Facades\Storage::fake('local');

    $this->seed(\Database\Seeders\UserSeeder::class);

    $this->user = \App\Models\User::first();
  }

  public function test_花の色で、植物を検索する()
  {
    $plant1 = Plant::factory()->recycle($this->user)->create();
    $plant1->colors()->sync([1, 2, 3]); // 白、黄、橙

    $plant2 = Plant::factory()->recycle($this->user)->create();
    $plant2->colors()->sync([3, 4, 5]); // 橙、ピンク、赤

    $plant3 = Plant::factory()->recycle($this->user)->create();
    $plant3->colors()->sync([5, 6, 7]); // 赤、青、紫

    $response = $this->getJson(route(
      'search.colors',
      ['colors' => ['赤', '青']]
    ));

    $response->assertStatus(200)->assertJson([
      'current_page' => 1,
      'data' => [
        [
          'name' => $plant2->name,
        ],
        [
          'name' => $plant3->name,
        ]
      ]
    ]);
  }
}
