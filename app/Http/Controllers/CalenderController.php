<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calender\IndexCalenderRequest;
use App\Http\Requests\Calender\StoreCalenderRequest;
use App\Http\Requests\Calender\UpdateCalenderRequest;
use App\Http\Resources\CalenderResource;
use App\Models\Calender;
use App\Models\Course;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class CalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexCalenderRequest $request)
    {
        $data = $request->validated();

        $user = $request->user;

        $query = Calender::query();

        if($user->hasRole('client') && !isset($data['type'])){
            $course_ids = $user->subscriptions()->pluck('course_id')->unique()->toArray();

            $query->where(function($q) use ($course_ids) {
                $q->where(function($q2) use ($course_ids) {
                    $q2->where('calenderable_type', 'App\Models\Course')
                       ->whereIn('calenderable_id', $course_ids);
                })->orWhere('calenderable_type', '!=', 'App\Models\Course')
                ->orWhereNull('calenderable_type');
            });
        }

        $query->with(['calenderable:id,title']);

        $query->when(isset($data['query']), function ($query) use ($data) {
            $query->where('title', 'like', '%' . $data['query'] . '%');
        })->when(isset($data['type']), function ($query) use ($data , $user) {

            if($data['type'] == 'Course' && $user->hasRole('client')){
                $course_ids = $user->subscriptions()->pluck('course_id')->unique()->toArray();

                $query->where(function($q2) use ($course_ids) {
                    $q2->where('calenderable_type', 'App\Models\Course')
                       ->whereIn('calenderable_id', $course_ids);
                });
            }else {
                $query->where('calenderable_type', 'App\Models\\' . $data['type']);
            }
        })->when(isset($data['institute_id']), function ($query) use ($data) {
            $query->where('institute_id', $data['institute_id']);
        });

        $calenders = $query->get();

        return $this->respondOk(CalenderResource::collection($calenders));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCalenderRequest $request)
    {
        $data = $request->validated();


        if($data['type'] != 'General'){
            $data['calenderable_type'] = "App\Models\\" . $data['type'];
            $data['calenderable_id'] = $data[strtolower($data['type']) . '_id'];
        }

        // dd($data);

        $calender = Calender::create($data);
        
        $calender->load(['calenderable:id,title']);

        // return $this->respondOk($calender);
        return $this->respondCreated(CalenderResource::make($calender) , __('calender.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Calender $calender)
    {
        return $this->respondOk(CalenderResource::make($calender->load('calenderable:id,title')) , __('calender.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalenderRequest $request, Calender $calender)
    {
        $data = $request->validated();


        if($data['type'] != 'General'){
            $data['calenderable_type'] = "App\Models\\" . $data['type'];
            $data['calenderable_id'] = $data[strtolower($data['type']) . '_id'];
        }

        $calender->update($data);

        return $this->respondOk(CalenderResource::make($calender->load(['calenderable:id,title'])) , __('calender.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calender $calender)
    {
        $calender->delete();

        return $this->respondNoContent();
    }
}
