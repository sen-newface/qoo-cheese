<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Event as EventResource;

class EventsController extends Controller
{
    /**
     * イベント一覧取得
     * ! 複数のイベント取得はリソースコレクションで対応
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * 認証キーと紐づくイベント取得
     * ? これは別コントローラに切り分けたほうがスッキリする？ 
     * 
     * @return void
     */
    public function auth()
    {
        //
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
        return [
            'status' => 204
        ];
    }
}
