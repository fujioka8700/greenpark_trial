<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Http\Requests\StorePlantPostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PlantController extends Controller
{
  const DISPLAY_NUMBER = 10; // 検索後、表示する植物の数

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * 植物を登録する。
   * @param \App\Http\Requests\StorePlantPostRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StorePlantPostRequest $request): JsonResponse
  {
    $path = $request->file->store('public/images');
    $path = str_replace('public/', '/storage/', $path);

    $user = Auth::user();

    $plant = $user->plants()->create([
      'name' => $request->name,
      'file_path' => $path,
      'description' => $request->description,
    ]);

    return response()->json($plant, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   */
  public function show(Plant $plant)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Plant $plant)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Plant $plant)
  {
    //
  }

  /**
   * 植物を検索する。
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function search(Request $request): JsonResponse
  {
    /** キーワード受け取り */
    $keyword = $request->input('keyword');

    /** クエリ生成 */
    $query = Plant::query();

    /** もしキーワードがあったら */
    if (!empty($keyword)) {
      $query->where('name', 'like', '%' . $keyword . '%');
    }

    $data = $query->orderBy('created_at', 'desc')->paginate(self::DISPLAY_NUMBER);

    return response()->json($data, Response::HTTP_OK);
  }
}
