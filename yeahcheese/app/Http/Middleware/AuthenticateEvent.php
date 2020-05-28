<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Event;
use Carbon\Carbon;

class AuthenticateEvent
{
    public function handle($request, Closure $next)
    {
        $user = auth('sanctum')->user();
        $key = $request->key;
        $event = Event::where('key', $key)->first();
        $request = $this->getRequest($request, $user, $event);
        return $next($request);
    }
    /**
     * ユーザーの種類とイベントの有無に応じて、レスポンス内容を変化させて返却
     */
    private function getRequest($request, $user, $event)
    {
        $request = $this->isValidKey($request, $user, $event);
        return $request;
    }

    /**
     * 有効な認証キーか無効な認証キーかによってレスポンス内容を変化させて返却
     */
    private function isValidKey($request, $user, $event)
    {
        if (is_null($event)) {
            $request = $this->createErrorResponse($request, ['認証キーが間違っています'], 406);
        } else {
            $request = $this->withinDeadline($request, $user, $event);
        }
        return $request;
    }

    /**
     * 公開期限内か公開期限外かによってレスポンス内容を変化させて返却
     */
    private function withinDeadline($request, $user, $event)
    {
        // ログイン済みユーザーは公開期限に関わらず成功
        // ユーザーが保持していないイベントにアクセスしようとした場合は403エラーを飛ばす
        if ($user) {
            $key = $request->key;
            $event = $user->events()->where('key', $key)->first();
            $request = $this->hasUserEvent($request, $event);
            return $request;
        }
        // ゲストユーザーの場合は、公開期限によって分岐させる
        if ($this->checkDeadline($event)) {
            $request = $this->createSuccessResponse($request, $event);
        } else {
            $request = $this->createErrorResponse($request, ['公開期限外のイベントです'], 422);
        }
        return $request;
    }

    /**
     * ログインユーザーに紐づくイベントであるかによってレスポンス内容を変化させる
     */
    private function hasUserEvent($request, $event)
    {
        if ($event) {
            $request = $this->createSuccessResponse($request, $event);
        } else {
            $request = $this->createErrorResponse($request, ['閲覧権限がありません'], 403);
        }
        return $request;
    }

    /**
     * 成功時のレスポンスを作成
     */
    private function createSuccessResponse($request, $event)
    {
        $path = $this->getPath($event);
        $opt = [
            'errors' => null,
            'status' => 200,
            'event' => $event,
            'path' => $path,
        ];
        $request->merge($opt);
        return $request;
    }

    /**
     * エラー時のレスポンスを作成
     */
    private function createErrorResponse($request, $errors, $status)
    {
        $opt = [
            'errors' => $errors,
            'status' => $status,
            'key' => $request->key,
        ];
        $request->merge($opt);
        return $request;
    }

    /**
     * 取得できたイベントが公開期限内であるかどうかの判定
     */
    private function checkDeadline($event)
    {
        $today = Carbon::now();
        $start_date = $event->start_date;
        $end_date = $event->end_date;
        $within = $today->between($start_date, $end_date);
        return $within;
    }

    /**
     * 認証後の遷移先パスを変化させて返却
     */
    private function getPath($event)
    {
        $path = '/events/event-' . $event->id;
        return $path;
    }
}
