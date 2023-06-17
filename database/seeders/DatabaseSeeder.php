<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plant;
use App\Models\Color;
use App\Models\Place;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
  const USERS_COUNT = 5; // 作成するユーザー数
  const PLANTS_COUNT = 10; // 作成する植物数

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->deleteAllPlantImages();

    /** ログインしやすいユーザーの作成 */
    $user = User::factory()->create([
      'name' => 'Test User',
      'email' => 'test@example.com',
    ]);

    /** ユーザー作成 */
    $users = User::factory(self::USERS_COUNT)->create();

    /** ログインしやすいユーザーを1番目に追加 */
    $users->prepend($user);

    /** 植物の色 */
    $colors = Color::all();

    /** 植物の生育場所 */
    $places = Place::all();

    /**
     * 1対多 ユーザー 対 植物
     * 植物を作成するユーザーはランダム
     */
    Plant::factory(self::PLANTS_COUNT)
      ->recycle($user)
      ->create()
      ->each(
        function ($plant) use ($colors, $places) {
          /**
           * 多対多 植物 対 色
           * 植物の色はランダム(白～その他)
           */
          $plant
            ->colors()
            ->attach($colors->random(random_int(1, $colors->count())));

          /**
           * 多対多 植物 対 生育場所
           * 植物の生育場所はランダム(街路～社寺)
           */
          $plant
            ->places()
            ->attach($places->random(random_int(1, $places->count())));
        }
      );
  }

  /**
   * storage/app/public/images ディレクトリ内の、植物写真のファイルを全て削除する
   */
  public function deleteAllPlantImages(): void
  {
    $allFiles = Storage::allFiles('public/images/');

    $notDeleteFile = array_search('public/images/.gitignore', $allFiles, true);

    array_splice($allFiles, $notDeleteFile, 1);

    Storage::delete($allFiles);
  }
}
