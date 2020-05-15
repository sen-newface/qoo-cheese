<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Event;
use App\Http\Resources\Event as EventResource;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')
            ->except(['auth', 'show']);
    }

    public function index()
    {
        //
    }
    public function auth()
    {
        //
    }
    public function show()
    {

        //
    }
    public function store(StoreEventRequest $request)
    {   
        $request->merge(['user_id' => $request->user()->id]);
        
        $event = Event::create($request->toArray());

        return new EventResource($event);
    }
    public function update()
    {
        //
    }
    public function destroy()
    {
        //
    }
}
