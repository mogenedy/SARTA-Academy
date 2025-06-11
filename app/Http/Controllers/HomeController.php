<?php

namespace App\Http\Controllers;

use App\Http\Requests\Home\GlobalSearchRequest;
use App\Http\Resources\AboutHomeResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\DirectorMessageResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\HomeCounterResource;
use App\Http\Resources\HomeSliderResource;
use App\Http\Resources\InstituteResource;
use App\Http\Resources\TestimonialResource;
use App\Http\Resources\UserResource;
use App\Models\AboutHome;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Course;
use App\Models\DirectorMessage;
use App\Models\Event;
use App\Models\HomeCounter;
use App\Models\HomeSlider;
use App\Models\Institute;
use App\Models\Testimonial;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {

        $homeSlider = HomeSlider::all();

        $institutes =  Institute::all(['id' , 'name' , 'short_name']);

        $courses = Course::with('users')->isLive(true)->inRandomOrder()->limit(5)->get();

        $testimonials = Testimonial::all();

        $aboutHome = AboutHome::first();

        $directorMessage = DirectorMessage::first(['id' , 'title' , 'description']);

        $homeCounters = HomeCounter::all(['id' , 'title' , 'number']);

        $latestEvents = Event::latest()->limit(4)->get();

        $latestBlogs = Blog::with(['tags' , 'blog_category'])->latest()->limit(4)->get();

        return $this->respondOk([
            'homeSlider' => HomeSliderResource::collection($homeSlider),
            'institutes' => InstituteResource::collection($institutes),
            'courses' => CourseResource::collection($courses),
            'testimonials' => TestimonialResource::collection($testimonials),
            'aboutHome' => AboutHomeResource::make($aboutHome),
            'directorMessage' => DirectorMessageResource::make($directorMessage),
            'homeCounter' => HomeCounterResource::collection($homeCounters),
            'latestEvents' => EventResource::collection($latestEvents),
            'latestBlogs' => BlogResource::collection($latestBlogs),
        ]);

    }

    public function global_search(GlobalSearchRequest $request)
    {

        $data = $request->validated();

        $courses = Course::isLive(true)->where('title' , 'like' , '%' . $data['query'] . '%')->limit(7)->get();

        $researchers = User::role('researcher')->where('name' , 'like' , '%' . $data['query'] . '%')->limit(7)->get();

        // news

        // patent

        // klo klo

        return $this->respondOk([
            'courses' => CourseResource::collection($courses),
            'researcher' => UserResource::collection($researchers),
        ]);

    }
}
