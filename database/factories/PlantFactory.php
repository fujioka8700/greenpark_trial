<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plant>
 */
class PlantFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $path = fake()->image(storage_path('app/public/image'), 640, 480);
    $path = str_replace('/workspace/storage/app/public/', '/storage/', $path);

    return [
      'name' => fake()->realText(10),
      'file_path' => $path,
      'user_id' => User::factory(),
    ];
  }
}
