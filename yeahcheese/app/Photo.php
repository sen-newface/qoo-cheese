<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  /**
   * 写真のイベントを取得
   */
  public function event()
  {
    return $this->belongsTo('App\Event');
  }

  protected $fillable = [
    'image_path',
  ];
}
