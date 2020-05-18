<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhotoRequest;
use App\Event;
use App\Photo;

// ! リソースクラスがマージされたら、returnを書き換える
// ! それまでは仮のものを返す
class PhotosController extends Controller
{
    public function index()
    {
        return [
            'test' => 1234
        ];
    }
    public function store(StorePhotoRequest $request)
    {
        $photo = new Photo();
        $photo->fill($request->all())->save();
        return response($photo, 201);
    }
    public function destroy(Event $event, Photo $photo)
    {
        $photo->delete();
        return [
            'status' => 204
        ];
    }
}
