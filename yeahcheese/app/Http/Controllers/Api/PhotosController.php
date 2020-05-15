<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Photo;

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
    public function delete(Photo $photo)
    {
        $photo->delete();
        return [
            'status' => 204
        ];
    }
}
