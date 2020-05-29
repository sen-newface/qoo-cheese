<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhotoRequest;
use App\Event;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Resources\Photo as PhotoResource;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')
            ->except(['index']);
    }

    /**
     * イベントに紐づく写真の取得
     *
     * @return void
     */
    public function index(Event $event)
    {
        // TODO: Vueから受け取ったevent_idを含む、新規に保存したPhotoインスタンスをリソースクラスに渡す
        return response(PhotoResource::collection($event->photos, 200));
    }

    public function store(Event $event, Request $request)
    {
        if ($event->isOwner()) {
            $photos = [];
            foreach ($request->images as $index => $image) {
                $imagefile = $image;
                $filepath = Storage::disk('public')->putFile('images', $imagefile, 'public');
                $photo = new Photo();
                $photo->event_id = $request->event_id;
                $photo->image_path = $filepath;
                $photo->title = $request->titles[$index];
                $photo->save();
                array_push($photos, $photo);
            }
            return response(PhotoResource::collection($photos, 201));
        } else {
            return response(null, 403);
        }
    }

    public function destroy(Event $event, Photo $photo)
    {
        if ($event->isOwner()) {
            $photo->delete();
            return response('status', 204);
        } else {
            return response(null, 403);
        }
    }
}
