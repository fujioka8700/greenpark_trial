<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceControllerTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();
  }

  public function test_良く生えている場所、一覧を取得する(): void
  {
    $response = $this->getJson('/api/places');

    $response->assertStatus(200)->assertJson([
      ['name' => '街路'],
      ['name' => '生け垣'],
      ['name' => '市街地'],
      ['name' => '公園'],
      ['name' => '神社'],
      ['name' => '寺院'],
      ['name' => '道端'],
      ['name' => '草地'],
      ['name' => '空き地'],
      ['name' => '土手'],
      ['name' => '田畑'],
      ['name' => 'あぜ'],
      ['name' => '雑木林'],
      ['name' => '林緑'],
      ['name' => 'やぶ'],
      ['name' => '水辺'],
      ['name' => '海辺'],
    ]);
  }
}
