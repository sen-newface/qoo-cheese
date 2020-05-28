<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Favorite;
use App\Http\Resources\Favorite as FavoriteResource;
use App\Http\Resources\Photo as PhotoResource;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $user = auth('sanctum')->user();
        return response(PhotoResource::collection($user->photos, 200));
    }

    public function store(Request $request)
    {
        $user = auth('sanctum')->user();
        $target = Favorite::where('user_id', intval($user->id))
            ->where('photo_id', intval($request->photo_id))->get();
        if ($target->isEmpty()) {
            $favorite = new Favorite();
            $favorite->user_id = $user->id;
            $favorite->photo_id = $request->photo_id;

            return response(FavoriteResource::make(Favorite::create($favorite->toArray())), 201);
        }
        return response(null, 200);
    }

    public function destroy(Request $request)
    {
        $user = auth('sanctum')->user();
        $target = Favorite::where('user_id', intval($user->id))
            ->where('photo_id', intval($request->photo_id))->get();
        if (!$target->isEmpty()) {
            $target[0]->delete();
            return response(null, 204);
        }
        return response(null, 200);
    }
}
