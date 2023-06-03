<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
  /**
   * ユーザーをログインする。
   * ログインできない場合は、ステータスコード500を返す。
   * @param \Illuminate\Http\UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(UserRequest $request): JsonResponse
  {
    $credentials = $request->input();

    if (Auth::attempt($credentials)) {
      return response()->json([
        'status_code' => Response::HTTP_OK,
        'message' => 'success',
      ], Response::HTTP_OK);
    } else {
      return response()->json([
        'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
        'message' => 'Unauthorized',
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  /**
   * ユーザーをログアウトする。
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout(): JsonResponse
  {
    Auth::logout();

    return response()->json([
      'status_code' => Response::HTTP_OK,
      'message' => 'Logged out',
    ], Response::HTTP_OK);
  }
}
