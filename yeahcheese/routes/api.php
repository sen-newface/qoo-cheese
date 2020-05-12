<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('events/auth', 'Api\EventsController@auth')->name('events.auth');

Route::resource('events', 'Api\EventsController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
Route::resource('events.photos', 'Api\PhotosController', ['only' => ['index', 'store', 'destroy']]);
