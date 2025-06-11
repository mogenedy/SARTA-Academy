<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lesson\IndexLessonRequest;
use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

use function PHPUnit\Framework\throwException;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     // add index for lesson with or without a course_id
    public function index(IndexLessonRequest $request)
    {
        $data = $request->validated();

        $lessons = Lesson::query()->where('course_id' , $data['course_id']);

        $lessons->when($data['query'] , function ($query) use ($data) {
            $query->where('title' , 'like' , '%'.$data['query'].'%');
        });

        $lessons = $lessons->paginate();

        return $this->respondOk(LessonResource::collection($lessons), __('lesson.index'));
    } 

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        $data = $request->validated();
        $user = $request->user;
        $course = Course::find($data['course_id']);

        if ($user->cannot('create', [Lesson::class , $course])) {
            throw new UnauthorizedException();
        }

        $lesson = Lesson::create($data);
        return $this->respondCreated(LessonResource::make($lesson), __('lesson.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        return $this->respondOk(LessonResource::make($lesson) , __('lesson.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $data = $request->validated();
        $user = $request->user;

        if ($user->cannot('update', [Lesson::class , $lesson])) {
            throw new UnauthorizedException();
        }

        $lesson->update($data);
        return $this->respondOk(LessonResource::make($lesson) , __('lesson.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Lesson $lesson)
    {
        $user = $request->user;
        
        if ($user->cannot('update', [Lesson::class , $lesson])) {
            throw new UnauthorizedException();
        }

        $lesson->delete();
        return $this->respondNoContent();
    }
}
