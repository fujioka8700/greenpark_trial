<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
  ];

  /**
   * 1対多のplantsテーブル(子テーブル)でusersテーブル(親テーブル)のリレーションを定義
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
