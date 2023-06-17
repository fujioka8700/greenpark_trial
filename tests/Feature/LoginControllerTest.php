<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class LoginControllerTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private $user;

  protected function setUp(): void
  {
    parent::setUp();

    $this->seed(\Database\Seeders\UserSeeder::class);

    $this->user = \App\Models\User::find(1);
  }

  public function test_正しいメールアドレスとパスワードでログインする(): void
  {
    $response = $this->postJson('/api/login', [
      'email' => $this->user->email,
      'password' => 'password',
    ]);

    $response->assertStatus(200)->assertJson([
      'status_code' => 200,
      'message' => 'success',
    ]);
  }

  public function test_誤ったメールアドレスとパスワードではログインできない(): void
  {
    $response = $this->postJson('/api/login', [
      'email' => $this->faker->email,
      'password' => $this->faker->password,
    ]);

    $response->assertStatus(500)->assertJson([
      'status_code' => 500,
      'message' => 'Unauthorized',
    ]);
  }

  public function test_ログイン情報の取得(): void
  {
    $response = $this->actingAs($this->user)->getJson('/api/user');

    $response->assertStatus(200)->assertJson([
      'name' => $this->user->name,
      'email' => $this->user->email,
    ]);
  }

  public function test_ログアウトする(): void
  {
    $response = $this->actingAs($this->user)->postJson('/api/logout');

    $response->assertStatus(200)->assertJson([
      'status_code' => 200,
      'message' => 'Logged out',
    ]);
  }
}
