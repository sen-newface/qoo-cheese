<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
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
        $event = Event::all()->where("key", $request->key)->first();
        if (!$event) {
            return response("認証キーが間違っています", 406);
        }
        return response(new EventResource($event), 200);
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
    public function update(Event $event, StoreEventRequest $request)
    {
        if ($event->isOwner()) {
            $form = $request->all();
            $event->fill($form)->save();
            return response(new EventResource($event), 200);
        }
        return response(null, 403);
    }

    /**
     * イベント削除
     */
    public function destroy(Event $event, Request $request)
    {
        $event->delete();
        // TODO: イベント削除の処理
        if ($event->isOwner()) {
            $event->delete();
            return response(null, 204);
        }
        return response(null, 403);
    }
}
