<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MultiWordSearchTest extends TestCase
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

  public function test_複数の単語で、植物の名前・特徴を検索する(): void
  {
    \App\Models\Plant::factory()->recycle($this->user)->create([
      'name' => 'さくら',
      'description' => '花はピンク色です。'
    ]);

    \App\Models\Plant::factory()->recycle($this->user)->create([
      'name' => 'ひまわり',
      'description' => '花は黄色です。'
    ]);

    $response = $this->getJson(route(
      'search.plant',
      ['keyword' => '黄色'],
    ));

    $response->assertStatus(200)->assertJson([
      'current_page' => 1,
      'data' => [
        [
          'name' => 'ひまわり',
          'description' => '花は黄色です。',
        ]
      ]
    ]);
  }
}
