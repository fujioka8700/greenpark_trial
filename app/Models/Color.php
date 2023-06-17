<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Color extends Model
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
   * 多対多 plants と colors
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function plants(): BelongsToMany
  {
    return $this->belongsToMany(\App\Models\Plant::class)->withTimestamps();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getAllColors(): Collection
  {
    return $this->all();
  }
}
