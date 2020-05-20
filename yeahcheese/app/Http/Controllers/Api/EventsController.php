<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;
use App\Event;
use App\Http\Resources\Event as EventResource;

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
    public function index()
    {
        // TODO: ユーザーに紐づくイベントを複数取得
        // return EventResource::collection($events);
    }

    /**
     * 認証キーと紐づくイベント取得
     */
    public function auth()
    {
        // TODO: トークンを利用して認証キーをあれこれ照合して、認証キーに紐づくイベントを取得し、リソースクラスに渡す
        // return new EventResource($event);
    }

    /**
     * 単一イベント取得
     */
    public function show(Event $event)
    {

        //
    }
    public function store(StoreEventRequest $request)
    {
        $request->merge(['user_id' => $request->user()->id]);

        return EventResource::make(Event::create($request->toArray()));
    }

    /**
     * イベント情報更新（写真を除く）<pp></pp>
     */
    public function update(Event $event)
    {
        // TODO: イベントを更新してから、そのインスタンスをリソースクラスに渡す
        // return new EventResource($event);
    }

    /**
     * イベント削除
     */
    public function destroy(Event $event, Request $request)
    {
        // TODO: イベント削除の処理
        if ($request->user()->id == $event->user_id) {
            $event->delete();
            return response(null, 204);
        }
        return response(null, 403);
    }
}
