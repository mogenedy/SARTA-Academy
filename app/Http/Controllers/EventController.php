<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\IndexEventRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexEventRequest $request)
    {
        $data = $request->validated();

        $query = Event::query();

        $query->when(isset($data['query']) , function($query) use($data){
            $query->where('title' , 'like' , '%'.$data['query'].'%');
        })->when(isset($data['sort_by']) , function($query) use($data){
            if($data['asc']){
                $query->orderBy($data['sort_by']);
            } else{
                $query->orderByDesc($data['sort_by']);
            }
        })->when(isset($data['by_time']) , function($query) use($data){
            if($data['by_time'] == 'upcoming'){
                $query->where('date' , '>' , now());
            } else{
                $query->where('date' , '<' , now());
            }
        });

        $events = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(EventResource::collection($events) , __("event.index"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        $event = Event::create($data);

        $event->addMediaFromRequest('image')->toMediaCollection("main");

        if(isset($data['blogs'])){
            $event->blogs()->sync($data['blogs']);
        }

        return $this->respondCreated(EventResource::make($event) , __("event.store"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return $this->respondOk(EventResource::make($event->load('blogs')) , __("event.show"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();

        $event->update($data);

        if ($request->hasFile('image')) { 
            $event->clearMediaCollection("main");
            $event->addMediaFromRequest('image')->toMediaCollection("main");
        }

        if(isset($data['blogs'])){
            $event->blogs()->sync($data['blogs']);
        }

        return $this->respondOk(EventResource::make($event) , __("event.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return $this->respondNoContent();
    }
}
