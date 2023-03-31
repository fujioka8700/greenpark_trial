<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
  /**
   * ユーザー情報を登録する。
   * 登録失敗の時は、ステータスコード422を返す。
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    User::create([
      'name' =>  $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    return response()->json('User registration completed', Response::HTTP_OK);
  }
}
