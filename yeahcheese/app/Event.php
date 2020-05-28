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

    public static function myEvents()
    {
        $user = auth('sanctum')->user();
        return $user ? Event::with(['photos'])->where('user_id', $user->id)->get() : [];
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

    public function isOwner()
    {
        $user = auth('sanctum')->user();
        return $user ? intval($this->user_id) === intval($user->id) : false;
    }

    protected $fillable = [
    'name', 'start_date', 'end_date', 'user_id'
    ];
}
