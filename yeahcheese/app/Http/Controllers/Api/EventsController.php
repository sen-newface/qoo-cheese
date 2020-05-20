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
        return $event;
    }

    public function store(StoreEventRequest $request)
    {   
        $request->merge(['user_id' => $request->user()->id]);
        
        return EventResource::make(Event::create($request->toArray()));
    }

    /**
     * イベント情報更新（写真を除く）
     */
    public function update(Event $event, StoreEventRequest $request)
    {
        $event->name = $request['name'];
        $event->start_date = $request['start_date'];
        $event->end_date = $request['end_date'];
        $event->save();
        // TODO: イベントを更新してから、そのインスタンスをリソースクラスに渡す
        return response(new EventResource($event), 201);
    }

    /**
     * イベント削除
     */
    public function destroy(Event $event): array
    {
        // TODO: イベント削除の処理
        return [
            'status' => 204
        ];
    }
}
