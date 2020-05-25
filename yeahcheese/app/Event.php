<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Event extends Model
{
    public static function boot()
    {
        parent::boot();
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
        return $this->hasMany('App\Photo')->orderBy('created_at', 'desc');
    }

    protected $fillable = [
    'name', 'start_date', 'end_date', 'user_id'
    ];
}
