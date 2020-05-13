<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;

class UsersController extends Controller
{
    /**
     * ユーザー取得
     *
     * @return void
     */
    public function index()
    {
        // ! ログインしていない場合はnullが返却
        $user = Auth::user();
        return new UserResource($user);
    }

    /**
     * アカウント作成
     *
     * @return void
     */
    public function register()
    {
        //TODO: ユーザー登録処理
        // ? Laravel標準のを用いれば一発？
        // return new UserResource($user);
    }

    /**
     * ログイン
     *
     * @return void
     */
    public function login()
    {
        //TODO: ログイン処理
        // ? Laravel標準のを用いれば一発？
        // return new UserResource($user);
    }

    /**
     * ログアウト
     *
     * @return void
     */
    public function logout()
    {
        //TODO: ログアウト処理
        // ? Laravel標準のを用いれば一発？
        return [
            'status' => 204
        ];
    }

}
