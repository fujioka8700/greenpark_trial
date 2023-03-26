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
    $path = fake()->image(storage_path('app/public/images'), 640, 480);
    $path = preg_replace('/(.*)public/', '/storage', $path);

    return [
      'name' => fake()->realText(10),
      'file_path' => $path,
      'user_id' => User::factory(),
    ];
  }
}
