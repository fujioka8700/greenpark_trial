<?php

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
    Schema::create('color_plant', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('plant_id');
      $table->unsignedBigInteger('color_id');
      $table->timestamps();

      $table->foreign('plant_id')->references('id')->on('plants')->cascadeOnDelete();
      $table->foreign('color_id')->references('id')->on('colors')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('color_plant');
  }
};
