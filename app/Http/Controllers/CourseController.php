<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\IndexAdminCourseRequest;
use App\Http\Requests\Course\IndexCourseRequest;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Models\User;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(IndexCourseRequest $request)
    {
        $data = $request->validated();

        $query = Course::query()->with(['users' , 'category' , 'institute:id,name'])->isLive(true);

        $query->when(isset($data['state']) , function($query) use($data){
            if($data['state'] == "active"){
                $query->where('start_date' , '<=' , now())
                    ->where('end_date' , '>=' , now());
            }else if ($data['state'] == "expired"){
                $query->where('end_date' , "<" , now());;
            } else {
                $query->where('start_date' , ">" , now());
            }
        })->when(isset($data['sort_by']), function ($query) use ($data) {
            if ($data['asc']) {
                $query->orderBy($data['sort_by']);
            } else {
                $query->orderByDesc($data['sort_by']);
            }
        })->when(isset($data['online']) , function($query) use($data) {
            $query->where('online' , $data['online']);
        })->when(isset($data['query']) , function($query) use($data){
            $query->where('title', 'like', '%' . $data['query'] . '%');
        })->when(isset($data['institute_id']) , function($query) use($data){
            $query->where('institute_id' , $data['institute_id']);
        })->when(isset($data['category_id']) , function($query) use($data){
            $query->where('category_id' , $data['category_id']);
        })->when(isset($data['price']) , function($query) use($data){
            if($data['price'] == "paid"){
                $query->where('price' , '<>' , 0);
            }else if($data['price'] == "free"){
                $query->where('price' , 0);
            }
        })->when(isset($data['researchers']) , function($query) use($data){
            $query->whereHas('users' , function($q) use($data){
                $q->whereIn('id' , $data['researchers']);
            });
        });

        $courses = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(CourseResource::collection($courses)->response()->getData(), __("course.index"));
    }


    public function index_admin(IndexAdminCourseRequest $request)
    {
        $data = $request->validated();

        $query = Course::query()->with(['users' , 'category' , 'institute:id,name']);

        $query->when(isset($data['state']) , function($query) use($data){
            if($data['state'] == "active"){
                $query->where([['start_date' , '<=' , now()] , ['end_date' , '>=' , now()]]);
            }else if ($data['state'] == "expired"){
                $query->where('end_date' , "<" , now());;
            } else {
                $query->where('start_date' , ">" , now());
            }
        })->when(isset($data['sort_by']), function ($query) use ($data) {
            if ($data['asc']) {
                $query->orderBy($data['sort_by']);
            } else {
                $query->orderByDesc($data['sort_by']);
            }
        })->when(isset($data['online']) , function($query) use($data) {
            $query->where('online' , $data['online']);
        })->when(isset($data['live']) , function($query) use($data) {
            $query->isLive($data['live']);
        })->when(isset($data['query']) , function($query) use($data){
            $query->where('title', 'like', '%' . $data['query'] . '%');
        })->when(isset($data['user_id']) , function($query) use($data){
            $query->whereHas('users' , function($q) use($data){
                $q->where('id' , $data['user_id']);
            });
        })->when(isset($data['institute_id']) , function($query) use($data){
            $query->where('institute_id' , $data['institute_id']);
        })->when(isset($data['category_id']) , function($query) use($data){
            $query->where('category_id' , $data['category_id']);
        })->when(isset($data['price']) , function($query) use($data){
            if($data['price'] == "paid"){
                $query->where('price' , '<>' , 0);
            }else if($data['price'] == "free"){
                $query->where('price' , 0);
            }
        })->when(isset($data['researchers']) , function($query) use($data){
            $query->whereHas('users' , function($q) use($data){
                $q->whereIn('id' , $data['researchers']);
            });
        });

        $courses = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(CourseResource::collection($courses)->response()->getData(), __("course.index"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $userIds = $request->validated()['user_ids'];
    
        $users = User::whereIn('id', $userIds)->whereHas('roles',function($query) { 
            $query->where('name', 'researcher');
        })->count();

        if ($users != count($userIds)) {
            return $this->respondError('All selected users must be an researcher');
        }
        
        $course = Course::create($request->validated());

        $course->addMediaFromRequest('image')->toMediaCollection("main");

        $course->users()->attach($userIds);
        return $this->respondCreated(CourseResource::make($course), __("course.store"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load('users');
        $course->setRelation('lessons',  $course->lessons()->paginate());
        $course->load('category');        
        $course->setRelation('main_group',  $course->groups()->where('is_main' , 1)->first());
        $course->load('institute:id,name');

        return $this->respondOk(CourseResource::make($course), __("course.show"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        if(isset( $request->validated()['user_ids'])){
            $userIds = $request->validated()['user_ids']; 
    
            $users = User::whereIn('id', $userIds)->whereHas('roles',function($query) { 
                $query->where('name', 'researcher');
            })->count();
    
            if ($users != count($userIds)) {
                return $this->respondError('All selected users must be an researcher');
            }
            
            $course->users()->sync($userIds);
        }

        $course->update($request->validated());

        if ($request->hasFile('image')) { 
            $course->clearMediaCollection("main");
            $course->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk(CourseResource::make($course), __("course.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return $this->respondNoContent();
    }
}
