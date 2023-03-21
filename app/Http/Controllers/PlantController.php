<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePlantPostRequest;

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
    $user = Auth::user();

    $plant = $user->plants()->create($request->all());

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
}
