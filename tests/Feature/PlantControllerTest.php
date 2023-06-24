<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plant;
use App\Models\Color;
use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;
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

  public function test_1つの植物（関連付けした色と生育場所）を返す(): void
  {
    Storage::fake('local');

    $createPlants = 1;
    $plants = $this->relatedPlants($createPlants);
    $plant = $plants->first();

    $plantColors = [];
    foreach ($plant->colors as $color) {
      array_push($plantColors, ['name' => $color->name]);
    }

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


  public function test_生育場所「街路・生け垣」で検索し、一覧を取得する(): void
  {
    Storage::fake('local');

    $relationPlaces = Place::where('name', '街路')->get();

    $plants = Plant::factory(1)
      ->hasAttached($relationPlaces)
      ->recycle($this->user)->create();

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

    $createPlants = 5;
    $this->relatedPlants($createPlants);

    $plantsArray = Plant::all()->toArray();

    $plantsName = [];
    foreach ($plantsArray as $key => $value) {
      array_push($plantsName, $value['name']);
    }

    $response = $this->getJson(route('recommend.plants'));

    $maxValue = max(array_keys($plantsArray));
    $randomNumber = mt_rand(0, $maxValue);

    $response->assertStatus(200)->assertJsonFragment([
      'name' => $plantsName[$randomNumber],
    ]);
  }

  public function test_1つの植物を削除する(): void
  {
    Storage::fake('local');

    $createPlants = 3;
    $plants = $this->relatedPlants($createPlants);

    $response = $this->actingAs($this->user)->deleteJson("/api/plants/{$plants->first()->id}");

    $response->assertStatus(200)->assertSee(1);

    $this->assertEquals(Plant::all()->count(), $plants->count() - 1);
  }

  public function test_1つの植物を更新する(): void
  {
    Storage::fake('local');

    // リレーションする 白、黄 を取り出す
    $colors = Color::query()->whereIn('name', ['白', '黄'])->get();

    // リレーションする 街路、生け垣 を取り出す
    $places = Place::query()->whereIn('name', ['街路', '生け垣'])->get();

    $plant = Plant::factory()
      ->for($this->user)
      ->hasAttached($colors)
      ->hasAttached($places)->create();

    // 修正する内容
    $newName = 'ソメイヨシノ';
    $newDescription = 'ソメイヨシノの花はピンク色です。';
    $newColors = Color::query()->whereIn('name', ['ピンク', '赤'])->get();
    $newPlaces = Place::query()->whereIn('name', ['市街地', '公園'])->get();

    $response = $this->actingAs($this->user)->patchJson(
      "/api/plants/{$plant->id}",
      [
        'name' => $newName,
        'description' => $newDescription,
        'places' => $newPlaces->pluck('id')->toArray(),
        'colors' => $newColors->pluck('id')->toArray(),
      ],
    );

    $response->assertStatus(200)->assertJson([
      'name' => $newName,
      'description' => $newDescription,
    ]);
  }

  /**
   * 色と生育場所を関連付けした、植物たちを作成する
   * @param int $number
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function relatedPlants(int $number): Collection
  {
    $relationColors = Color::all()->random(random_int(1, Color::all()->count()));
    $relationPlaces = Place::all()->random(random_int(1, Place::all()->count()));

    $plants = Plant::factory($number)
      ->hasAttached($relationColors)
      ->hasAttached($relationPlaces)
      ->recycle($this->user)->create();

    return $plants;
  }
}
