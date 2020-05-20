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

    public function auth()
    {
        // TODO: トークンを利用して認証キーをあれこれ照合して、認証キーに紐づくイベントを取得し、リソースクラスに渡す
        // return new EventResource($event)
    }

    /**
     * イベント一覧取得
     */
    public function index(Request $request)
    {
        return EventResource::collection($request->user()->events);
    }

    /**
     * 単一イベント取得
     */
    public function show(Request $request, Event $event)
    {
        $user = auth('sanctum')->user();
        $key = $request->key;
        if ($user && !$key) {
            //TODO ポリシーでやる
            if ($event->user_id == $user->id) {
                return response(new EventResource($event), 200);
            } else {
                return response(null, 403);
            }
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
    public function update(Event $event)
    {
        // TODO: イベントを更新してから、そのインスタンスをリソースクラスに渡す
        // return new EventResource($event);
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
