<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Photo as PhotoResource;

class PhotosController extends Controller
{
    /**
     * イベントに紐づく写真の追加
     *
     * @return void
     */
    public function store()
    {
        // TODO: Vueから受け取ったevent_idを含む、新規に保存したPhotoインスタンスをリソースクラスに渡す
        // return new PhotoResource($photo);
    }

    /**
     * イベントに紐づく写真の削除
     *
     * @return void
     */
    public function delete()
    {
        // TODO: イベントに紐づく写真削除の処理
        return [
            'status' => 204
        ];
    }
}
