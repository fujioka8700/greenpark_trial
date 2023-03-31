<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  const USERS_COUNT = 5;   // 作成するユーザー数
  const PLANTS_COUNT = 10; // 作成する植物数

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    /** ログインしやすいユーザーの作成 */
    $user = User::factory()->create([
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ]);

    /** 5ユーザー作成 */
    $users = User::factory(self::USERS_COUNT)->create();

    /** ログインしやすいユーザーを1番目に追加 */
    $users->prepend($user);

    /** ユーザーとリレーションした、植物を作成 */
    Plant::factory(self::PLANTS_COUNT)->recycle($users)->create();
  }
}
