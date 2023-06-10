<?php

namespace App\Services;

use App\Models\User;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PlantService
{
  const DISPLAY_NUMBER = 10; // 検索後、表示する植物の数

  private $plant;

  public function __construct()
  {
    $this->plant = new Plant();
  }

  /**
   * @param \Illuminate\Http\Request $request
   */
  public function storeOnePlant(Request $request)
  {
    $filePath = $this->saveImageFile($request);

    $convertedFilePath = $this->convertFilePath($filePath);

    $loginUser = Auth::user();

    $storedPlant = $this->storePlant($loginUser, $request, $convertedFilePath);

    $this->storeFlowerColors($request, $storedPlant);

    $this->storeGrowPlaces($request, $storedPlant);

    return $storedPlant;
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return string
   */
  public function saveImageFile(Request $request): string
  {
    return $request->file->store('public/images');
  }

  /**
   * @param string $filePath
   * @return string
   */
  public function convertFilePath(string $filePath): string
  {
    return str_replace('public/', 'storage/', $filePath);;
  }

  /**
   * @param \App\Models\User $user
   * @param \Illuminate\Http\Request $request
   * @param string $path
   * @return \App\Models\Plant
   */
  public function storePlant(User $user, Request $request, string $path): Plant
  {
    return $user->plants()->create([
      'name' => $request->name,
      'file_path' => $path,
      'description' => $request->description,
    ]);
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Plant $plant
   */
  public function storeFlowerColors(Request $request, $plant): void
  {
    if (isset($request->colors)) {
      $this->storeMultipleColors($request, $plant);
    } else {
      $this->storeOtherColor($plant);
    }
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Plant $plant
   */
  public function storeMultipleColors(Request $request, Plant $plant): void
  {
    $colors = explode(",", $request->colors);

    $plant->colors()->attach($colors);
  }

  /**
   * @param \App\Models\Plant $plant
   */
  public function storeOtherColor(Plant $plant): void
  {
    $otherColor = DB::table('colors')->latest('id')->first()->id;

    $plant->colors()->attach($otherColor);
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Plant $plant
   */
  public function storeGrowPlaces(Request $request, Plant $plant): void
  {
    if (isset($request->places)) {
      $places = explode(",", $request->places);

      $plant->places()->attach($places);
    }
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function searchPlantName(Request $request): LengthAwarePaginator
  {
    $searchKeyword = $this->getKeyword($request);
    $plantQuery = '';

    if (!empty($searchKeyword)) {
      // $plantQuery->where('name', 'like', '%' . $searchKeyword . '%');
      $plantQuery = $this->plant->createPlantNameQuery($searchKeyword);
    } else {
      $plantQuery = $this->plant->createPlantQueryBuilder();
    }

    $searchResults = $plantQuery->orderBy('created_at', 'desc')->paginate(self::DISPLAY_NUMBER);

    return $searchResults;
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return string|null
   */
  public function getKeyword(Request $request): string|null
  {
    return $request->query('keyword');
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function searchPlantsPlaces(Request $request): LengthAwarePaginator
  {
    $searchPlaces = $request->query('places');
    $query = '';

    if (!empty($searchPlaces)) {
      $query = $this->plant->createPlacesQuery($searchPlaces);
    }

    $searchResults = $query->orderBy('created_at', 'desc')->paginate(self::DISPLAY_NUMBER);

    return $searchResults;
  }
}
