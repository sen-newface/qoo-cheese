<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('events/auth', 'Api\EventsController@auth')->name('events.auth');

Route::resource('events', 'Api\EventsController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
Route::resource('events.photos', 'Api\PhotosController', ['only' => ['index', 'store', 'destroy']]);

//usercheck
Route::middleware('auth:sanctum')->get('/user', "Api\AuthController@me")->name('auth.me');

//作成
Route::post('/signup', "Api\AuthController@signup")->name('auth.signup');

//login
Route::post('/login', "Api\AuthController@login")->name('auth.login');


Route::get('/likes', "Api\FavoritesController@index")->name('like.index');
Route::post('/likes', "Api\FavoritesController@store")->name('like.store');
Route::delete('/likes', "Api\FavoritesController@destroy")->name('like.destroy');
