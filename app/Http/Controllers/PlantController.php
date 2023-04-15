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
    // 画像ファイルを保存する
    $path = $request->file->store('public/images');

    // 画像ファイルを表示できるパスに変換する
    $path = str_replace('public/', 'storage/', $path);

    // ログイン中のユーザー
    $user = Auth::user();

    // 植物を登録する
    $plant = $user->plants()->create([
      'name' => $request->name,
      'file_path' => $path,
      'description' => $request->description,
    ]);

    // 花の色がある場合は、花の色を保存する
    if (isset($request->colors)) {
      // 花の色を文字列から、配列へ変換する
      $colors = explode(",", $request->colors);

      // 登録した植物と、花の色を紐付ける
      $plant->colors()->attach($colors);
    }

    return response()->json($plant, Response::HTTP_CREATED);
  }

  /**
   * 1つ植物と、リレーションしているものを取得する
   */
  public function show(Plant $plant)
  {
    // 植物と、紐付いている色を取得する
    $plant = $plant->with('colors')->find($plant->id);

    return response()->json($plant, Response::HTTP_OK);
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
