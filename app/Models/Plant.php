<?php

namespace App\Models;

use App\Models\User;
use App\Models\Color;
use App\Models\Place;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
  use HasFactory;

  /**
   * createメソッドを使用時、許可する属性
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'file_path',
    'description',
  ];

  /**
   * 多対1 plants(子) 対 users(親)
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  /**
   * 多対多 plants と colors
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function colors(): BelongsToMany
  {
    return $this->belongsToMany(Color::class)->withTimestamps();
  }

  /**
   * 多対多 plants と places
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function places(): BelongsToMany
  {
    return $this->belongsToMany(Place::class)->withTimestamps();
  }

  /**
   * ランダムに5つの植物を取得する
   * @return array
   */
  public function fetchRandomFivePlants(): array
  {
    return $this::all()->random(5)->all();
  }

  /**
   * 1つの植物と、植物に紐づいている情報を取得する。
   * @param \App\Models\Plant $plant
   * @return \App\Models\Plant
   */
  public function getOnePlant(Plant $plant): Plant
  {
    return $plant->with(['colors', 'places'])->find($plant->id);
  }

  /**
   * @param array $searchPlaces
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function createPlacesQuery(array $searchPlaces): Builder
  {
    return $this::whereHas('places', function ($query) use ($searchPlaces) {
      $query->whereIn('name', $searchPlaces);
    });
  }

  /**
   * @param string $searchKeyword
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function createPlantNameQuery(string $searchKeyword): Builder
  {
    return $this->query()->where('name', 'like', '%' . $searchKeyword . '%');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function createPlantQueryBuilder(): Builder
  {
    return $this::query();
  }

  /**
   * @param int $plantId
   * @return int
   */
  public function destroyPlantAndRelations(int $plantId): int
  {
    return $this::destroy($plantId);
  }
}
