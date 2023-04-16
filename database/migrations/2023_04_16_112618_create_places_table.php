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
      ['name' => '公園'],
      ['name' => '社寺'],
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
