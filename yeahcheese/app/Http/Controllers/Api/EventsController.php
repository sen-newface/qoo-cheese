<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Event as EventResource;

class EventsController extends Controller
{
    /**
     * イベント一覧取得
     * @return void
     */
    public function index()
    {
        // TODO: ユーザーに紐づくイベントを複数取得
        // return EventResource::collection($events);
    }

    /**
     * 認証キーと紐づくイベント取得
     * ? これは別コントローラに切り分けたほうがスッキリする？ 
     * 
     * @return void
     */
    public function auth()
    {
        // TODO: トークンを利用して認証キーをあれこれ照合して、認証キーに紐づくイベントを取得し、リソースクラスに渡す
        // return new EventResource($event);
    }

    /**
     * 単一イベント取得
     *
     * @return void
     */
    public function show()
    {
        // TODO: Vueから受け取ったevent_idで単一のイベントを取得して、リソースクラスに渡す
        // return new EventResource($event);
    }

    /**
     * イベント追加
     *
     * @return void
     */
    public function store()
    {
        // TODO: イベントを作成してから、その戻り値のインスタンスをリソースクラスに渡す
        // return new EventResource($event);
    }

    /**
     * イベント情報更新（写真を除く）
     *
     * @return void
     */
    public function update()
    {
        // TODO: イベントを更新してから、そのインスタンスをリソースクラスに渡す
        // return new EventResource($event);
    }

    /**
     * イベント削除
     *
     * @return void
     */
    public function destroy()
    {
        // TODO: イベント削除の処理
        return [
            'status' => 204
        ];
    }
}
