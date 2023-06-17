<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plant>
 */
class PlantFactory extends Factory
{
  const IMAGE_WIDTH = 640;  // ダミー画像の幅
  const IMAGE_HEIGHT = 480; // ダミー画像の高さ
  const NAME_COUNT = 10;    // 植物名の文字上限
  const DESC_COUNT = 100;   // 植物説明の文字上限

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $dummyImage = UploadedFile::fake()->image(
      'dummy.jpg',
      self::IMAGE_WIDTH,
      self::IMAGE_HEIGHT
    );

    $filePath = $dummyImage->store('public/images');

    // ファイルパスを変更して、画像にアクセスできるようにする
    $replacedFilePath = preg_replace('/(.*)public/', '/storage', $filePath);

    return [
      'name' => fake()->realText(self::NAME_COUNT),
      'file_path' => $replacedFilePath,
      'user_id' => User::factory(),
      'description' => fake()->realText(self::DESC_COUNT),
    ];
  }
}
