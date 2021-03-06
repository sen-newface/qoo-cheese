<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Request;
use App\Event;
use App\Http\Resources\Event as EventResource;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')
            ->except(['auth', 'show']);
        $this->middleware('auth-event')
            ->only(['auth']);
    }
    /**
     * イベント一覧取得
     */
    public function index(Request $request)
    {
        return EventResource::collection(Event::myEvents());
    }

    public function auth(Request $request)
    {
        if (is_null($request->errors)) {
            $event = $request->event;
            $opt = $request->only('status', 'path');
            $resource = new EventResource($event);
            $resource->additional($opt);
            return $resource;
        }
        $response = $request->only('errors', 'status', 'key');
        return response($response);
    }

    /**
     * 単一イベント取得
     */
    public function show(Request $request, Event $event)
    {
        $key = $request->key;
        if ($event->isOwner()) {
            return response(new EventResource($event), 200);
        }
        if ($event->key == $key) {
            return response(new EventResource($event), 200);
        }
        return response(false, 403);
    }

    public function store(StoreEventRequest $request)
    {
        $request->merge(['user_id' => $request->user()->id]);
        return response(EventResource::make(Event::create($request->toArray())), 201);
    }

    /**
     * イベント情報更新（写真を除く）
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $form = $request->all();
        $event->fill($form)->save();
        return response(new EventResource($event), 200);
    }

    /**
     * イベント削除
     */
    public function destroy(Event $event, Request $request)
    {
        // TODO: イベント削除の処理
        if ($event->isOwner()) {
            $event->delete();
            return response(null, 204);
        }
        return response(null, 403);
    }
}
