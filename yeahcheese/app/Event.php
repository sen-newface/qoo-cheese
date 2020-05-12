<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Event extends Model
{
  public static function boot()
  {
    parent::boot();
    //イベント作成時にkeyにランダムな文字列を挿入
    Event::creating(function ($event) {
      $event->key = Str::random(30);
    });
  }

  /**
   * イベントの持ち主を取得
   */
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  /**
   * イベントの写真を取得
   */
  public function photos()
  {
    return $this->hasMany('App\Photo');
  }

  protected $fillable = [
    'name', 'start_day', 'end_day',
  ];
}