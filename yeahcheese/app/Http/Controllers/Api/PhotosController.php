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
      return response(new PhotoResource($photo), 201);
  }

  public function destroy(Event $event, Photo $photo)
  {
      $photo->delete();
      return response('status', 204);
  }

}
