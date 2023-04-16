<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
use App\Models\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceControllerTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  protected function setUp(): void
  {
    parent::setUp();

    // ユーザー1人、作成
    $user = User::factory()->create();

    // 良く生えている場所1つとリレーションした、植物を作成
    Plant::factory(1)
      ->recycle($user)
      ->create()
      ->each(function ($plant) {
        $plant->places()->attach(1);
      });
  }

  public function test_良く生えている場所、一覧を取得する(): void
  {
    $response = $this->getJson('/api/places');

    $response->assertStatus(200)->assertJson([
      ['name' => '街路'],
      ['name' => '公園'],
      ['name' => '社寺'],
    ]);
  }
}
