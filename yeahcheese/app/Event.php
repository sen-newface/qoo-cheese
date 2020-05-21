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
        Event::creating(
            function ($event) {
                $event->key = Str::random(30);
            }
        );
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
    'name', 'start_date', 'end_date', 'user_id'
    ];

    // 使用してないメソッド、戻り値おかしい, めっちゃ長いメソッド
    private function no(): array
    {
        // インデント異常, 不使用変, 少数文字
          $a = [];
    $bbb = [];











































































        // ifの後スペースなし、閉じかっこの後スペースなし、複雑すぎる
        if(true) {
            if (true){
                if (true) {
                    if (true) {
                        if (true) {
                            if (true) {
                                if (true) {
                                    if (true) {
                                        if (true) {
                                            if (true) {
                                                if (true) {
                                                    if (true) {
                                                        if (true) {
                                                            if (true) {
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // カンマのあとスペースなし
        $cc = [1,2];
    }
}
