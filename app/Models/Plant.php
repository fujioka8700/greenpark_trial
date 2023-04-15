<?php

namespace App\Models;

use App\Models\User;
use App\Models\Color;
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
}
