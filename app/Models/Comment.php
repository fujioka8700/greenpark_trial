<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  /**
   * createメソッドを使用時、許可する属性
   */
  protected $fillable = [
    'comment',
    'plant_id',
    'user_id',
  ];

  /**
   * 日付のフォーマットを変更する
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'created_at'        => 'datetime:Y-m-d H:i:s',
    'updated_at'        => 'datetime:Y-m-d H:i:s',
  ];

  /**
   * １対多（逆）／所属 plantsテーブル
   */
  public function plant(): BelongsTo
  {
    return $this->belongsTo(\App\Models\Plant::class);
  }

  /**
   * １対多（逆）／所属 usersテーブル
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(\App\Models\User::class);
  }
}
