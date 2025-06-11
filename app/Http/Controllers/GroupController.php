<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\IndexGroupRequest;
use App\Http\Requests\Group\MainGroupRequest;
use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Models\Group;
use App\Http\Resources\GroupResource;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexGroupRequest $request)
    {
        $data = $request->validated();

        $query = Group::query()->where('course_id' , $data['course_id']);

        $query->when(isset($data['query']) , function($query) use($data){
            $query->where('name', 'like', '%' . $data['query'] . '%');
        })->when(isset($data['live']) , function($query) use($data){
           $query->where('live' , $data['live']); 
        })->when(isset($data['state']) , function($query) use($data){
            if($data['state'] == "expired"){
                $query->where('expires_at' , '<' , now());
            }else{
                $query->where('expires_at' , '>' , now());
            }
        })->when(isset($data['is_main']) , function($query) use($data){
            $query->where('is_main' , $data['is_main']);
        });

        $groups = $query->paginate();

        return $this->respondOk(GroupResource::collection($groups)->response()->getData(), __('group.index'));
    }

    public function main_group(MainGroupRequest $request)
    {
        $data = $request->validated();

        $course = Course::find($data['course_id']);

        if (!$course->live){
            return $this->respondError('Course is not live');
        }

        if($course->end_date && $course->end_date < now()){
            return $this->respondError('Course has ended');
        }

        $group = Group::where([['course_id' , $data['course_id']],['is_main' , 1]])->first();

        if(!$group){
            return $this->respondError('There is no main group for this course');
        }

        return $this->respondOk(GroupResource::make($group), __('group.mainGroup'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $data = $request->validated();

        $course = Course::find($data['course_id']);

        if (!$course->live){
            return $this->respondError('Course is not live');
        }

        if($course->end_date){

            if($course->end_date < now()){
                return $this->respondError('Course has ended');
            }

            if($data['expires_at'] && $course->end_date < $data['expires_at']){
                return $this->respondError("expires_at shouldn't be greater than course end_date");
            }

        }

        
        if($data['is_main']){
            DB::table('groups')->where('course_id' , $data['course_id'])->update(['is_main' => 0]);
        }

        $group = Group::create($request->validated());

        return $this->respondCreated(GroupResource::make($group), __('group.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $group->load('course');
    }

     /**
     * Display the specified resource.
     */
    public function show_by_link(string $uuid)
    {
        $group = Group::where('uuid' , $uuid)->firstOrFail();
        
        if(!$group->live){
            return $this->respondError('Group is not live');
        }

        if($group->expires_at && $group->expires_at < now()){
            return $this->respondError('Group registration has ended');
        }

        return $this->respondOk(GroupResource::make($group), __('group.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {        
        $data = $request->validated();
     
        $expires_at = $group->expires_at;

        if ($data['expires_at']) {
            $expires_at = $data['expires_at'];
        };

        $course = Course::find($data['course_id']);

        if (!$course->live){
            return $this->respondError('Course is not live');
        }

        if($course->end_date){

            if($course->end_date < now()){
                return $this->respondError('Course has ended');
            }

            if($expires_at && $course->end_date < $expires_at){
                return $this->respondError("expires_at shouldn't be greater than course end_date");
            }

        }

        if(isset($data['is_main']) && $data['is_main']){
            DB::table('groups')->where('course_id' , $data['course_id'])->update(['is_main' => 0]);
        }

        $group->update($request->validated());
        
        return $this->respondOk(GroupResource::make($group), __('group.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return $this->respondNoContent();
    }
}
