<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
use App\Models\Color;
use App\Models\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PlantControllerTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private $user;

  protected function setUp(): void
  {
    parent::setUp();

    $this->seed(\Database\Seeders\UserSeeder::class);

    $this->user = User::first();
  }

  public function test_植物を登録する(): void
  {
    Storage::fake('local');

    $plantName = $this->faker()->text(10);
    $dummyImage = UploadedFile::fake()->image('dummy.jpg', 640, 480);
    $plantDescription = $this->faker()->text(100);

    $allPlaces = Place::query()->get()->toArray();
    $randomArray = array_rand($allPlaces, random_int(2, count($allPlaces)));

    foreach ($randomArray as $key) {
      $zeroOutArray[] = $allPlaces[$key]['id'];
    }

    $selectedPlaces = implode(',', $zeroOutArray);

    $response = $this->actingAs($this->user)->postJson('/api/plants', [
      'name' => $plantName,
      'file' => $dummyImage,
      'description' => $plantDescription,
      'places' => $selectedPlaces,
    ]);

    // アップロードされたファイルが保存されているか
    Storage::disk('local')->assertExists("public/images/{$dummyImage->hashName()}");

    $filePath = Plant::first()->file_path;

    $response->assertStatus(201)->assertJson([
      'name' => $plantName,
      'file_path' => $filePath,
      'description' => $plantDescription,
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

  public function test_植物を名前で検索し、一覧を取得する(): void
  {
    Storage::fake('local');

    $this->seed(\Database\Seeders\PlantSeeder::class);

    $searchKeyWord = Plant::find(1)->name;
    $filePath = Plant::find(1)->file_path;
    $fileName = preg_replace('/(.*)images\//', '', $filePath);

    // 画像のファイルが保存されているか確認する
    Storage::disk('local')->assertExists("public/images/{$fileName}");

    $response = $this->getJson(route(
      'search.plant',
      ['keyword' => $searchKeyWord],
    ));

    $response->assertStatus(200)->assertJson([
      'current_page' => 1,
      'data' => [
        [
          'name' => $searchKeyWord,
          'file_path' => $filePath,
        ]
      ]
    ]);
  }

  public function test_1つの植物（紐づけした色、生育場所も）を返す(): void
  {
    Storage::fake('local');

    // ランダムに、紐づける色を決定する
    $colors = Color::all()->random(random_int(1, 9));

    // ランダムに、生育場所を紐づける。
    $places = Place::all()->random(random_int(1, 3));

    // 植物を1つ登録（画像ファイルも保存）し、色を紐づける
    $plants = Plant::factory(1)
      ->hasAttached($colors)
      ->hasAttached($places)
      ->recycle($this->user)->create();

    $plant = $plants->first();

    // 紐づけした色を、配列にする
    $plantColors = [];
    foreach ($plant->colors as $color) {
      array_push($plantColors, ['name' => $color->name]);
    }

    // 紐づけした生育場所を、配列にする
    $plantPlaces = [];
    foreach ($plant->places as $place) {
      array_push($plantPlaces, ['name' => $place->name]);
    }

    $response = $this->getJson("/api/plants/{$plant->id}");

    $response->assertStatus(200)->assertJson([
      'name' => $plant->name,
      'colors' => $plantColors,
      'places' => $plantPlaces,
    ]);
  }


  public function test_生育場所で検索し、一覧を取得する(): void
  {
    Storage::fake('local');

    // 生育場所を街路にする
    $places = Place::where('name', '街路')->get();

    $plants = Plant::factory(1)
      ->hasAttached($places)
      ->recycle($this->user)->create();

    // 街路、生け垣で検索する
    $response = $this->getJson(route(
      'search.places',
      ['places' => ['街路', '生け垣']]
    ));

    $response->assertStatus(200)->assertJson([
      'current_page' => 1,
      'data' => [
        [
          'name' => $plants->first()->name,
        ],
      ]
    ]);
  }

  public function test_TOP画面「注目の植物たち」で表示する植物(): void
  {
    Storage::fake('local');

    // ランダムに、紐づける色を決定する
    $colors = Color::all()->random(random_int(1, 9));

    // ランダムに、生育場所を紐づける。
    $places = Place::all()->random(random_int(1, 3));

    // 植物を10個登録（画像ファイルも保存）し、色を紐づける
    Plant::factory(5)
      ->hasAttached($colors)
      ->hasAttached($places)
      ->recycle($this->user)->create();

    // コレクションから配列作成
    $plantsArray = Plant::all()->toArray();

    // 配列から名前の配列作成
    $plantsName = [];
    foreach ($plantsArray as $key => $value) {
      array_push($plantsName, $value['name']);
    }

    $response = $this->getJson(route('recommend.plants'));

    // レスポンス中のどこかに、
    // 指定JSONデータが含まれているかテストする
    $random_int = mt_rand(0, 4);
    $response->assertStatus(200)->assertJsonFragment([
      'name' => $plantsName[$random_int],
    ]);
  }
}
