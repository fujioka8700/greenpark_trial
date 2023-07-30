<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Services\PlantService;
use App\Http\Requests\PlantRequest;
use App\Http\Requests\UpdatePlantRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PlantController extends Controller
{
  const MAX_DISPLAY = 10; // 検索後、表示する植物の最大数

  private $plant;
  private $plantService;

  public function __construct()
  {
    $this->middleware('auth')->only([
      'store',
      'destroy',
      'update',
    ]);

    $this->plant = new Plant();
    $this->plantService = new PlantService();
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * 植物(名前、色、生育地、特徴、ファイル)を登録する。
   * @param \App\Http\Requests\PlantRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(PlantRequest $request): JsonResponse
  {
    $storedPlant = $this->plantService->storeOnePlant($request);

    return response()->json($storedPlant, Response::HTTP_CREATED);
  }

  /**
   * 1つ植物の情報を取得する。
   * @param \App\Models\Plant $plant
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Plant $plant): JsonResponse
  {
    $displayPlant = $this->plant->getOnePlant($plant);

    return response()->json($displayPlant, Response::HTTP_OK);
  }

  /**
   * 1つ植物の情報を修正する。
   * @param \App\Http\Requests\UpdatePlantRequest $request
   * @param \App\Models\Plant $plant
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdatePlantRequest $request, Plant $plant): JsonResponse
  {
    // 新しい画像が、送信されてきたか確認
    if (isset($request->file)) {
      // 保存されている画像と被っていないか確認
      $existsFile = Storage::exists("public/images/{$request->file('file')->getClientOriginalName()}");

      if ($existsFile === false) {
        // 以前の画像ファイルを削除
        $deleteFile = preg_replace('/(.*)images\//', '', $plant->file_path);
        Storage::delete("public/images/{$deleteFile}");

        // 新しい画像ファイルを保存
        $filePath = $this->plantService->saveImageFile($request);

        // 新しい画像ファイルのパスへ更新
        $convertedFilePath = $this->plantService->convertFilePath($filePath);
        $plant->file_path = $convertedFilePath;
        $plant->save();
      }
    }

    // 名前、説明の更新
    $plant->name = $request->input('name');
    $plant->description = $request->input('description');
    $plant->save();

    // よく生えている場所、花の色の更新
    $plant->colors()->sync(explode(',', $request->colors));
    $plant->places()->sync(explode(',', $request->places));

    return response()->json($plant, Response::HTTP_OK);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Plant $plant)
  {
    $destroyResult = $this->plant->destroyPlantAndRelations($plant->id);

    if ($destroyResult == true) {
      $this->plantService->deletePlantImage($plant->file_path);
    }

    return response()->json($destroyResult, Response::HTTP_OK);
  }

  /**
   * 植物名を検索する。
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function search(Request $request): JsonResponse
  {
    $searchResults = $this->plantService->searchPlantName($request);

    return response()->json($searchResults, Response::HTTP_OK);
  }

  /**
   * 生育場所で検索し、植物一覧を取得する
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function searchPlaces(Request $request): JsonResponse
  {
    $searchResults = $this->plantService->searchPlantsPlaces($request);

    return response()->json($searchResults, Response::HTTP_OK);
  }

  /**
   * TOP画面「注目の植物たち」で表示する植物
   * @return \Illuminate\Http\JsonResponse
   */
  public function recommendPlants(): JsonResponse
  {
    try {
      $plants = $this->plant->fetchRandomFivePlants();
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
    }

    return response()->json($plants, Response::HTTP_OK);
  }

  /**
   * 花の色で検索し、植物一覧を取得する
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function searchColors(Request $request): JsonResponse
  {
    $searchColors = $request->query('colors');

    $query = Plant::whereHas('colors', function ($query) use ($searchColors) {
      $query->whereIn('name', $searchColors);
    });

    $searchResults = $query->orderBy('created_at', 'desc')->paginate(self::MAX_DISPLAY);

    return response()->json($searchResults, Response::HTTP_OK);
  }
}
