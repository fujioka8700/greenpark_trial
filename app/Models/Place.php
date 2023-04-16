<?php

namespace App\Models;

use App\Models\Plant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
  use HasFactory;

  /**
   * 配列に含めない属性
   * @var array
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * 多対多 plants と places
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function plants(): BelongsToMany
  {
    return $this->belongsToMany(Plant::class)->withTimestamps();
  }
}
