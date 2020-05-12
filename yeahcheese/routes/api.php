<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user', 'Api\UserController@index');
Route::post('register', 'Api\UserController@register');
Route::post('login', 'Api\UserController@login');
Route::get('logout', 'Api\UserController@logout');

Route::group(['prefix' => 'events'], function() {
    Route::get('{page}', 'Api\EventController@index');
    Route::post('auth', 'Api\EventController@auth');
    Route::get('{id}', 'Api\EventController@show');
    Route::post('/', 'Api\EventController@store');
    Route::put('{id}', 'Api\EventController@update');
    Route::delete('{id}', 'Api\EventController@delete');
});

