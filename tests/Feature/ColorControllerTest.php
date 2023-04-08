<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ColorControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * A basic feature test example.
   */
  public function test_花の色、一覧取得する(): void
  {
    $response = $this->getJson('/api/colors');

    $response->assertStatus(200)->assertJson([
      ['name' => '白'],
      ['name' => '黄'],
      ['name' => '橙'],
      ['name' => 'ピンク'],
      ['name' => '赤'],
      ['name' => '青'],
      ['name' => '紫'],
      ['name' => '緑'],
      ['name' => 'その他'],
    ]);
  }
}
