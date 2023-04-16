<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
use App\Models\Color;
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

    // 良く生えている場所を、「街路・公園・社寺」から選ぶ
    $array = [1, 2, 3];
    $response = [];
    foreach (array_rand($array, random_int(2, count($array))) as $key) {
      $response[] = $array[$key];
    }
    $places = implode(',', $response);

    $response = $this->actingAs($this->user)->postJson('/api/plants', [
      'name' => $name,
      'file' => $dummy,
      'description' => $description,
      'places' => $places,
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

  public function test_1つの植物を返す(): void
  {
    Storage::fake('local');

    // ランダムに、紐づける色を決定する
    $colors = Color::all()->random(random_int(1, 9));

    // 植物を1つ登録（画像ファイルも保存）し、色を紐づける
    $plants = Plant::factory(1)->hasAttached($colors)->recycle($this->user)->create();
    $plant = $plants->first();

    // 紐づけした色を、配列にする
    $plantColor = [];
    foreach ($plant->colors as $color) {
      array_push($plantColor, ['name' => $color->name]);
    }

    $response = $this->getJson("/api/plants/{$plant->id}");

    $response->assertStatus(200)->assertJson([
      'name' => $plant->name,
      'colors' => $plantColor,
    ]);
  }
}
