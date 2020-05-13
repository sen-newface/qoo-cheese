<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
  use HasApiTokens;

  public function me(Request $request)
  {
    $user = $request->user();
    $user->setToken();
    return response($user, 200);
  }

  public function signup(Request $request)
  {
    $user = new User;
    $form = $request->all();
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);
    $user->fill($form)->save();
    $user->setToken();
    return response($user, 200);
  }

  public function login(Request $request)
  {
    $user = User::all()->where("email", $request->email)->first();
    if (!$user || $user->password != $request->password) {
      return response("passwordかemailが間違っています", 401);
    }
    $user->setToken();
    return response($user, 200);
  }
}
