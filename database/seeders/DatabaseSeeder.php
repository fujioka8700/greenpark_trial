<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plant;
use App\Models\Color;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  const USERS_COUNT = 5; // 作成するユーザー数
  const PLANTS_COUNT = 3; // 作成する植物数
  const COLORS_COUNT = 9; // 色の数

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

    /** ユーザー作成 */
    $users = User::factory(self::USERS_COUNT)->create();

    /** ログインしやすいユーザーを1番目に追加 */
    $users->prepend($user);

    /** 植物の色を作成 */
    // $colors = Color::factory(self::COLORS_COUNT)->create();
    $colors = Color::all();

    /** 1対多 ユーザー 対 植物
     *  多対多 植物 対 色
     *   ・植物を作成するユーザーはランダム
     *   ・植物の色数はランダム(1～9)
     *  テーブルの作成
     */
    // Plant::factory(self::PLANTS_COUNT)->hasAttached($colors)->recycle($users)->create();
    Plant::factory(self::PLANTS_COUNT)
      ->recycle($users)
      ->create()
      ->each(fn ($plant) =>
      $plant
        ->colors()
        ->attach($colors->random(random_int(1, 9))));
  }
}
