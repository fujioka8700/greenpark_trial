<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
  const MAX_COMMENT = 100; // コメントの文字上限

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'comment' => fake()->realText(self::MAX_COMMENT),
      'user_id' => \App\Models\User::factory(),
      'plant_id' => \App\Models\Plant::factory(),
    ];
  }
}
