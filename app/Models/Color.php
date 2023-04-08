<?php

namespace App\Models;

use App\Models\Plant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
  use HasFactory;

  /**
   * 多対多 Plants と Colors
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function plants(): BelongsToMany
  {
    return $this->belongsToMany(Plant::class);
  }
}
