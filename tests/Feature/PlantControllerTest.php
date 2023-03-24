<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlantControllerTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  public $user;

  protected function setUp(): void
  {
    parent::setUp();

    $this->user = User::factory()->create();
  }

  public function test_植物を登録する(): void
  {
    $name = $this->faker()->text(10);

    $response = $this->actingAs($this->user)->postJson('/api/plants', [
      'name' => $name,
    ]);

    $response->assertStatus(201)->assertJson([
      'name' => $name,
    ]);
  }

  public function test_植物を名前未入力で登録する(): void
  {
    $response = $this->actingAs($this->user)->postJson('/api/plants', [
      'name' => '',
    ]);

    $response->assertStatus(422)->assertJson([
      'message' => '名前は必ず指定してください。',
    ]);
  }
}
