<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->only(['store', 'destroy']);
  }

  /**
   * 1つの植物のコメント一覧を取得する
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(Request $request): JsonResponse
  {
    $plantId = $request->input('plant_id');

    $comments = Comment::where('plant_id', $plantId)->with('user')->latest()->get();

    return response()->json($comments, Response::HTTP_OK);
  }

  /**
   * コメントを1つ書き込む。
   * @param \App\Http\Requests\CommentRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(CommentRequest $request): JsonResponse
  {
    $comment = Comment::create($request->input());

    return response()->json($comment, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * コメントを1つ削除する。
   * @param string $id 削除するコメントのid
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(string $id): JsonResponse
  {
    $deleteResult = Comment::destroy($id);

    return response()->json($deleteResult, Response::HTTP_OK);
  }
}
