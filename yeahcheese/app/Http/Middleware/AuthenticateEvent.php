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
        $user = Auth::user();
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
        $request = $this->isValidkeyOrInvalidKey($request, $user, $event);
        return $request;
    }

    /**
     * 有効な認証キーか無効な認証キーかによってレスポンス内容を変化させて返却
     */
    private function isValidkeyOrInvalidKey($request, $user, $event)
    {
        $opt = null;
        if (is_null($event)) {
            $opt = [
                'errors' => ['認証キーが間違っています'],
                'status' => 406,
                'key' => $request->key
            ];
            $request->merge($opt);
        } else {
            $request = $this->withinResponseOrOutsideResponse($request, $user, $event);
        }
        return $request;
    }

    /**
     * 公開期限内か公開期限外かによってレスポンス内容を変化させて返却
     */
    private function withinResponseOrOutsideResponse($request, $user, $event)
    {
        if ($this->checkDeadline($event)) {
            $path = $this->getPath($event);
            $opt = [
                'errors' => null,
                'status' => 200,
                'event' => $event,
                'path' => $path,
            ];
            $request->merge($opt);
        } else {
            $opt = [
                'errors' => ['公開期限外のイベントです'],
                'status' => 422,
                'key' => $request->key,
            ];
            $request->merge($opt);
        }
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
