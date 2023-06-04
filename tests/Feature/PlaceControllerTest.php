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
      ['name' => '公園'],
      ['name' => '社寺'],
    ]);
  }
}
