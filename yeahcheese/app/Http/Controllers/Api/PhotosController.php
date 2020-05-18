<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhotoRequest;
use App\Event;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Resources\Photo as PhotoResource;

class PhotosController extends Controller
{

    public function store(StorePhotoRequest $request)
    {
        $post_data = $request->except('image_path');
        $imagefile = $request->file('image_path');
        $filename = time() . '_' . $imagefile->getClientOriginalName();
        $path = $imagefile->storeAs('public/images', $filename);
        $photo = new Photo();
        $photo->event_id = $post_data['event_id'];
        $photo->image_path = str_replace('public/', 'storage/', $path);
        $photo->save();

        $opt = ['status' => 201];
        $resource = new PhotoResource($photo);
        $resource = $resource->additional($opt);
        return $resource;
    }

    public function destroy(Event $event, Photo $photo)
    {
        $photo->delete();
        return [
            'status' => 204
        ];
    }
}
