<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\Http\Resources\Favorite as FavoriteResource;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request)
    {
        $favorite = new Favorite();
        $favorite->user_id = $request->user_id;
        $favorite->photo_id = $request->photo_id;
        return response(FavoriteResource::make(Favorite::create($favorite->toArray())), 201);
    }

    public function destroy(Request $request)
    {
        $user = auth('sanctum')->user();
        $res = Favorite::where('user_id', intval($user->id))
            ->where('photo_id', intval($request->photo_id))->delete();
        if ($res) {
            return response(204);
        } else {
            return response(403);
        }
    }
}
