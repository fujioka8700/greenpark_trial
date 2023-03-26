<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class RegisterControllerTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  public function test_会員登録をする(): void
  {
    $name = $this->faker->name;
    $email = $this->faker->email;
    $password = $this->faker->password;

    $response = $this->postJson('/api/register', [
      'name' => $name,
      'email' => $email,
      'password' => $password,
    ]);

    // 正常に登録完了できているか確認。
    $response->assertStatus(200)->assertSeeText('User registration completed');

    $registeredUser = User::where('name', $name)->get()->first();

    // ユーザーが正しく登録できているか確認。
    $this->assertEquals($name, $registeredUser->name);
    $this->assertEquals($email, $registeredUser->email);
    $this->assertTrue(Hash::check($password, $registeredUser->password));
  }
}
