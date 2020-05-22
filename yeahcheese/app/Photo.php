<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    protected $fillable = [
        'image_path', 'event_id'
    ];
}
