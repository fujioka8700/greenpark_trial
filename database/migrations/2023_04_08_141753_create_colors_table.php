<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('colors', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->timestamps();
    });

    // 花の色は事前に用意しておく
    DB::table('colors')->insert([
      ['name' => '白'],
      ['name' => '黄'],
      ['name' => '橙'],
      ['name' => 'ピンク'],
      ['name' => '赤'],
      ['name' => '青'],
      ['name' => '紫'],
      ['name' => '緑'],
      ['name' => 'その他'],
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('colors');
  }
};
