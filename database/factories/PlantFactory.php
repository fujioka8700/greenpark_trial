<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plant>
 */
class PlantFactory extends Factory
{
  const IMAGE_WIDTH = 640;  // テスト画像の幅
  const IMAGE_HEIGHT = 640; // テスト画像の高さ
  const WORD_COUNT = 10;    // 植物名の文字上限

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $path = fake()->image(
      storage_path('app/public/images'),
      self::IMAGE_WIDTH,
      self::IMAGE_HEIGHT
    );
    $path = preg_replace('/(.*)public/', '/storage', $path);

    return [
      'name' => fake()->realText(self::WORD_COUNT),
      'file_path' => $path,
      'user_id' => User::factory(),
    ];
  }
}
