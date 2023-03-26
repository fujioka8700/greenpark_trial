<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class LoginControllerTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private $user;     // 新規ユーザー
  private $password; // 共有するパスワード

  protected function setUp(): void
  {
    parent::setUp();

    $this->password = $this->faker->password;

    $this->user = User::factory()->create([
      'name' => $this->faker->name,
      'email' => $this->faker->email,
      'password' => Hash::make($this->password),
    ]);
  }

  public function test_正しいメールアドレスとパスワードでログインする(): void
  {
    $response = $this->postJson('/api/login', [
      'email' => $this->user->email,
      'password' => $this->password,
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
    $newUser = User::factory()->create();

    $response = $this->actingAs($newUser)->getJson('/api/user');

    $response->assertStatus(200)->assertJson([
      'name' => $newUser->name,
      'email' => $newUser->email,
    ]);
  }

  public function test_ログアウトする(): void
  {
    $newUser = User::factory()->create();

    $response = $this->actingAs($newUser)->postJson('/api/logout');

    $response->assertStatus(200)->assertJson([
      'status_code' => 200,
      'message' => 'Logged out',
    ]);
  }
}
