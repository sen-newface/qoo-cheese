<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{

    public function me(Request $request)
    {
        $user = $request->user();
        $user->setToken();
        return response($user, 200)->header('authtoken', $user->token);
    }

    public function signup(CreateUserRequest $request)
    {
        $user = new User;
        $form = $request->all();
        $user->fill($form)->save();
        $user->setToken();
        return response($user, 201)->header('authtoken', $user->token);
    }

    public function login(Request $request)
    {
        $user = User::all()->where("email", $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(null, 401);
        }
        $user->setToken();
        return response($user, 200)->header('authtoken', $user->token);
    }
}
