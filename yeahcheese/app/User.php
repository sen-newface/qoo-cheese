<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public static function boot()
    {
        parent::boot();
        //イベント作成時にkeyにランダムな文字列を挿入
        User::creating(
            function ($user) {
                $user->password = Hash::make($user->password);
            }
        );
    }

    /**
     * イベントの写真を取得
     */
    public function events()
    {
        return $this->hasMany('App\Event')->orderBy('id', 'desc');
    }

    /**
     * お気に入りの写真を取得
     */
    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setToken($key = "authToken")
    {
        $token = $this->createToken($key)->plainTextToken;
        $this->token = $token;
    }
}
