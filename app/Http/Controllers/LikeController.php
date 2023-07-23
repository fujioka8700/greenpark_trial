<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->only([
      'show',
      'store',
      'destroy',
    ]);
  }

  /**
   * ログインユーザーのいいね状態を確認する
   * @param int $plantId
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(int $plantId): JsonResponse
  {
    $likeStatus = Auth::user()->isLiked($plantId);

    return response()->json($likeStatus, Response::HTTP_OK);
  }

  /**
   * いいねをする
   * @param int $plantId
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(int $plantId): JsonResponse
  {
    Auth::user()->like($plantId);

    $responseContent = 'like!';

    return response()->json($responseContent, Response::HTTP_CREATED);
  }

  /**
   * いいねを解除する
   * @param int $plantId
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(int $plantId): JsonResponse
  {
    Auth::user()->unlike($plantId);

    $responseContent = 'unlike!';

    return response()->json($responseContent, Response::HTTP_OK);
  }
}
