<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $photo = new Photo();
        // TODO: バリデーション
        $photo->fill($request->all())->save();
        return $photo->toArray();
    }
    public function destroy(Event $event, Photo $photo)
    {
        $photo->delete();
        return [
            'status' => 204
        ];
    }
}
