<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Http\Requests\StorePlantPostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StorePlantPostRequest $request)
  {
    $path = $request->file->store('public/images');
    $path = str_replace('public/', '/storage/', $path);

    $user = Auth::user();

    $plant = $user->plants()->create([
      'name' => $request->name,
      'file_path' => $path,
    ]);

    return response()->json($plant, 201);
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
   * 植物を検索します。
   */
  public function search(Request $request)
  {
    #キーワード受け取り
    $keyword = $request->input('keyword');

    #クエリ生成
    $query = Plant::query();

    #もしキーワードがあったら
    if (!empty($keyword)) {
      $query->where('name', 'like', '%' . $keyword . '%');
    }

    $data = $query->orderBy('created_at', 'desc')->paginate(10);

    return response()->json($data, 200);
  }
}
