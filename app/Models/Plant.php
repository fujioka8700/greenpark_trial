<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
  ];

  /**
   * 多対1のplantsテーブル(子テーブル)でusersテーブル(親テーブル)のリレーションを定義
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
