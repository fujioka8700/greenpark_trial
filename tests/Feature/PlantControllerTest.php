<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PlantControllerTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private $user; // 新規ユーザー

  protected function setUp(): void
  {
    parent::setUp();

    $this->user = User::factory()->create();
  }

  public function test_植物を登録する(): void
  {
    Storage::fake('local');

    $name = $this->faker()->text(10);
    $dummy = UploadedFile::fake()->image('dummy.jpg', 640, 480);
    $description = $this->faker()->text(100);

    $response = $this->actingAs($this->user)->postJson('/api/plants', [
      'name' => $name,
      'file' => $dummy,
      'description' => $description,
    ]);

    $path = Plant::first()->file_path;

    // アップロードされたファイルが保存されているか
    Storage::disk('local')->assertExists("public/images/{$dummy->hashName()}");

    $response->assertStatus(201)->assertJson([
      'name' => $name,
      'file_path' => $path,
      'description' => $description,
    ]);
  }

  public function test_植物の名前、ファイル未入力で登録する(): void
  {
    $response = $this->actingAs($this->user)->postJson('/api/plants', [
      'name' => '',
      'file' => '',
    ]);

    $response->assertStatus(422)->assertJson([
      'errors' => [
        'name' => ['名前は必ず指定してください。'],
        'file' => ['ファイルは必ず指定してください。'],
      ],
    ]);
  }

  public function test_植物を検索する(): void
  {
    Storage::fake('local');

    // 植物の登録と、画像のファイル保存
    User::factory()->hasPlants()->create();

    $serchKeyWord = Plant::find(1)->name; // 検索する文字列
    $file_path = Plant::find(1)->file_path; // 画像のファイルパス
    $file = preg_replace('/(.*)images\//', '', $file_path); // 保存された画像のファイル名

    // 画像のファイルが保存されているか確認する
    Storage::disk('local')->assertExists("public/images/{$file}");

    $response = $this->getJson('/api/plants/search', [
      'keyword' => $serchKeyWord,
    ]);

    $response->assertStatus(200)->assertJson([
      'current_page' => 1,
      'data' => [
        [
          'name' => $serchKeyWord,
          'file_path' => $file_path,
        ]
      ]
    ]);
  }
}
