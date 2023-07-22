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
      'store',
      'destroy',
    ]);
  }

  /**
   * いいねをする
   */
  public function store(int $plantId): JsonResponse
  {
    Auth::user()->like($plantId);

    $responseContent = 'like!';

    return response()->json($responseContent, Response::HTTP_CREATED);
  }

  /**
   * いいねを解除する
   */
  public function destroy(int $plantId): JsonResponse
  {
    Auth::user()->unlike($plantId);

    $responseContent = 'unlike!';

    return response()->json($responseContent, Response::HTTP_OK);
  }
}
