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

  protected function setUp(): void
  {
    parent::setUp();

    User::factory()->create([
      'name' => 'test',
      'email' => 'test@example.com',
      'password' => Hash::make('password'),
    ]);
  }

  public function test_正しいメールアドレスとパスワードでログインする(): void
  {
    $response = $this->postJson('/api/login', [
      'email' => 'test@example.com',
      'password' => 'password',
    ]);

    $response->assertStatus(200)->assertJson([
      'status_code' => 200,
      'message' => 'success',
    ]);
  }

  public function test_間違ったメールアドレスとパスワードでログインする(): void
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
}
