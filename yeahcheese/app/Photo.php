<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;

class Photo extends Model
{
    /**
     * 写真のイベントを取得
     */
    public static function boot()
    {
        parent::boot();
        // 写真作成時にstorageへのパスを付加
        Photo::creating(
            function ($photo) {
                $photo->image_path = "/storage/app/public/" . $photo->image_path;
            }
        );
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function favoriteUser()
    {
        return $this->belongsToMany('App\User', 'favorites');
    }

    public function isFavorite()
    {
        $user = auth('sanctum')->user();
        return $user ?
            !Favorite::where('user_id', intval($user->id))
                ->where('photo_id', $this->id)->get()->isEmpty()
            : false;
    }

    protected $fillable = [
        'image_path', 'event_id'
    ];
}
