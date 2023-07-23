<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $user = \App\Models\User::first();
    $plant = \App\Models\Plant::first();

    $user->likes()->attach($plant->id);
  }
}
