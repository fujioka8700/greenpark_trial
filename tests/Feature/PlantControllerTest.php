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

    $response = $this->actingAs($this->user)->postJson('/api/plants', [
      'name' => $name,
      'file' => $dummy,
    ]);

    $path = Plant::first()->file_path;

    // アップロードされたファイルが保存されているか
    Storage::disk('local')->assertExists("public/images/{$dummy->hashName()}");

    $response->assertStatus(201)->assertJson([
      'name' => $name,
      'file_path' => $path,
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

    $name = $this->faker()->text(10);
    $dummy = UploadedFile::fake()->image('dummy.jpg', 640, 480);

    $this->actingAs($this->user)->postJson('/api/plants', [
      'name' => $name,
      'file' => $dummy,
    ]);

    Storage::disk('local')->assertExists("public/images/{$dummy->hashName()}");

    // 検索する文字列を生成
    $serchKeyWord = substr($name, 0, 1);

    $response = $this->getJson('/api/plants/search', [
      'keyword' => $serchKeyWord,
    ]);

    $response->assertStatus(200)->assertJson([
      'data' => [
        [
          'file_path' => '/storage/images/' . $dummy->hashName(),
        ]
      ]
    ]);
  }
}
