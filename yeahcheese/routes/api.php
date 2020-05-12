<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('user', 'Api\UsersController@index');
Route::post('register', 'Api\UsersController@register');
Route::post('login', 'Api\UsersController@login');
Route::get('logout', 'Api\UsersController@logout');

Route::group(['prefix' => 'events'], function() {
    Route::get('{page}', 'Api\EventsController@index');
    Route::post('auth', 'Api\EventsController@auth');
    Route::get('{id}', 'Api\EventsController@show');
    Route::post('/', 'Api\EventsController@store');
    Route::put('{id}', 'Api\EventsController@update');
    Route::delete('{id}', 'Api\EventsController@delete');
});

