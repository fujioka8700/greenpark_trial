<?php

namespace App\Models;

use App\Models\Plant;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * 1対多 users(親) 対 plants(子)
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function plants(): HasMany
  {
    return $this->hasMany(Plant::class);
  }

  /**
   * １対多 commentsテーブル
   */
  public function comments(): HasMany
  {
    return $this->hasMany(\App\Models\Comment::class);
  }

  /**
   * 多対多 plantsテーブル
   * 中間テーブル likesテーブル
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function likes(): BelongsToMany
  {
    return $this->belongsToMany(Plant::class, 'likes', 'user_id', 'plant_id')->withTimestamps();
  }

  /**
   * この植物に対して既にlikeしたかどうかを判別する
   */
  public function isLiked(int $plantId): bool
  {
    return $this->likes()->where('plant_id', $plantId)->exists();
  }

  /**
   * 既にlikeしたか確認したあと、いいねする（重複させない）
   */
  public function like(int $plantId): void
  {
    if ($this->isLiked($plantId)) {
      //もし既に「いいね」していたら何もしない
    } else {
      $this->likes()->attach($plantId);
    }
  }

  /**
   * 既にlikeしたか確認して、もししていたら解除する
   */
  public function unlike(int $plantId): void
  {
    if ($this->isLiked($plantId)) {
      //もし既に「いいね」していたら消す
      $this->likes()->detach($plantId);
    }
  }
}
