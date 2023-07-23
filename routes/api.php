<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ログイン中ユーザーの情報を取得する
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

// ログイン、ログアウト、会員登録をする
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', [RegisterController::class, 'register']);

// キーワードを入力して植物を検索する
Route::get('/plants/search', [PlantController::class, 'search'])->name('search.plant');

// 生育場所で植物を検索する
Route::get('/plants/search-places', [PlantController::class, 'searchPlaces'])->name('search.places');

// TOP画面「注目の植物たち」で表示する植物
Route::get('/plants/recommend', [PlantController::class, 'recommendPlants'])->name('recommend.plants');

Route::group(['prefix' => 'plants', 'as' => 'plants.'], function () {
  // 1つの植物に対しての、いいね合計数
  Route::get('{plant}/like-count', [LikeController::class, 'index'])->name('like.count');

  // ログインユーザーのいいね状態を確認する
  Route::get('{plant}/like-status', [LikeController::class, 'show'])->name('like.status');

  // 既にlikeしたか確認したあと、いいねする（重複させない）
  Route::post('{plant}/like', [LikeController::class, 'store'])->name('like.store');

  // 既にlikeしたか確認して、もししていたら解除する
  Route::post('{plant}/unlike', [LikeController::class, 'destroy'])->name('like.destroy');
});

Route::apiResource('plants', PlantController::class, ['except' => ['index']]);
Route::apiResource('colors', \App\Http\Controllers\ColorController::class, ['only' => ['index']]);
Route::apiResource('places', \App\Http\Controllers\PlaceController::class, ['only' => ['index']]);
Route::apiResource('comments', \App\Http\Controllers\CommentController::class, ['only' => ['index', 'store']]);
