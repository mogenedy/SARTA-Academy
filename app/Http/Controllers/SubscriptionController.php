<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\Subscription\IndexAdminSubscriptionRequest;
use App\Http\Requests\Subscription\IndexSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Course;
use App\Models\Group;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexSubscriptionRequest $request)
    {
        $data = $request->validated();
        $user = $request->user;

        $subscriptions = Subscription::where('user_id' , $user->id)->with(['group:id,name,is_main,expires_at,max_users,live' , 'course:id,title,online,start_date,end_date,live,level' , 'user'])
        ->paginate($data['per_page'] ?? 15);

        return $this->respondOk(SubscriptionResource::collection($subscriptions) , __("subscription.index"));
    }


    /**
     * Display a listing of the resource.
     */
    public function index_admin(IndexAdminSubscriptionRequest $request)
    {
        $data = $request->validated();

        $query = Subscription::query()->with(['user']);
    
        // Apply filters based on group_id and course_id if provided
        $query->when(isset($data['group_id']), function($query) use ($data) {
            $query->where('group_id', $data['group_id']);
        })->when(isset($data['course_id']), function($query) use ($data) {
            $query->where('course_id', $data['course_id']);
        });
    
        $subscriptions = $query->paginate($data['per_page'] ?? 15);
    
        $groupIds = $subscriptions->pluck('group_id')->unique();
        $courseIds = $subscriptions->pluck('course_id')->unique();
    
        $groups = Group::where('id', $groupIds)->get(['id', 'name', 'is_main', 'expires_at', 'max_users', 'live']);
        $courses = Course::where('id', $courseIds)->get(['id', 'title', 'online', 'start_date', 'end_date', 'live', 'level']);

        $subscriptions->groups = $groups;
        $subscriptions->courses = $courses;
        
        return $this->respondOk($subscriptions , __("subscription.index"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request , string $uuid)
    {
        $user = $request->user;

        $group = Group::where('uuid' , $uuid)->firstOrFail();

        if(!$group->live){
            return $this->respondError('Group is not live');
        }

        if($group->expires_at && $group->expires_at < now()){
            return $this->respondError('Group registration has ended');
        }

        if($group->max_users && $group->subscriptions()->count() >= $group->max_users){
            return $this->respondError('Group is full');
        }

        $course = $group->course;

        if(!$course->live){
            return $this->respondError('Course is not live');
        }

        if($course->start_date && $course->start_date > now()){
            return $this->respondError("Course hasn't started yet");
        }

        if($course->end_date && $course->end_date < now()){
            return $this->respondError('Course has ended');
        }

        $subscription = $user->subscriptions()->where('course_id' , $course->id)->exists();

        if($subscription){
            return $this->respondError('Already subscribed to this course');
        }
        
        if($course->price == 0){
            
            $subscription = $user->subscriptions()->create([
                'group_id' => $group->id,
                'course_id' => $course->id
            ]);

            return $this->respondCreated($subscription , __("subscription.store"));

        } else {

            //payment Gateway

            $subscription = $user->subscriptions()->create([
                'group_id' => $group->id,
                'course_id' => $course->id
            ]);

            return $this->respondCreated($subscription , __("subscription.store"));

        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return $this->respondNoContent();   
    }
}
