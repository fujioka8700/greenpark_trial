<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('places', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->timestamps();
    });

    // 「良く生えている場所」は事前に用意しておく
    DB::table('places')->insert([
      ['name' => '街路'],
      ['name' => '生け垣'],
      ['name' => '市街地'],
      ['name' => '公園'],
      ['name' => '神社'],
      ['name' => '寺院'],
      ['name' => '道端'],
      ['name' => '草地'],
      ['name' => '空き地'],
      ['name' => '土手'],
      ['name' => '田畑'],
      ['name' => 'あぜ'],
      ['name' => '雑木林'],
      ['name' => '林緑'],
      ['name' => 'やぶ'],
      ['name' => '水辺'],
      ['name' => '海辺'],
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('places');
  }
};
