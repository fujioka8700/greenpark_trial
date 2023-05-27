<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ColorController extends Controller
{
  private $color;

  public function __construct()
  {
    $this->color = new Color();
  }

  /**
   * 花の色、一覧を取得する。
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(): JsonResponse
  {
    return response()->json($this->color->getAllColors(), Response::HTTP_OK);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
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
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
