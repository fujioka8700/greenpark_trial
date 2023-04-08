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
    Schema::create('plants', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedBigInteger('user_id');
      $table->string('file_path');
      $table->text('description');
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('plants');
  }
};
