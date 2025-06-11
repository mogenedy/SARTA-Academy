<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\IndexBlogRequest;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
 
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexBlogRequest $request)
    {
        $data =  $request->validated();
        
        $query  = Blog::query();

        $query->when(isset($data['query']), function($query) use ($data){
            $query->where('title' , 'like' , '%'.$data['query'].'%');
        })->when(isset($data['sort_by']), function($query) use ($data){
            if($data['asc']){
                $query->orderBy($data['sort_by']);
            } else{
                $query->orderByDesc($data['sort_by']);
            }
        })->when(isset($data['tags']), function($query) use ($data){
            $query->whereHas('tags' , function($q) use ($data){
                $q->whereIn('blog_tags.id' , $data['tags']);
            });
        })->when(isset($data['blog_category_id']) , function($query) use($data){
            $query->where('blog_category_id' , $data['blog_category_id']);
        });

        $blogs = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(BlogResource::collection($blogs)->response()->getData() , __("blog.index"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        $blog = Blog::create($data);

        $blog->tags()->sync($data['tags']);

        if(isset($data['events'])){
            $blog->events()->sync($data['events']);
        }
        
        $blog->addMediaFromRequest('image')->toMediaCollection('main');

        return $this->respondCreated(new BlogResource($blog) , __("blog.store"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {

        return $this->respondOk(new BlogResource($blog->load(['blog_category' , 'tags' , 'events'])) , __("blog.show"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        $blog->update($data);

        if($request->hasFile('image')){
            $blog->clearMediaCollection('main');
            $blog->addMediaFromRequest('image')->toMediaCollection('main');
        }

        if(isset($data['tags'])){
            $blog->tags()->sync($data['tags']);
        }

        if(isset($data['events'])){
            $blog->events()->sync($data['events']);
        }

        return $this->respondOk(new BlogResource($blog) , __("blog.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return $this->respondNoContent();
    }

    public function getRecentBlogs(){
       
        $blogs = Blog::latest()->take(3)->get();
        return $this->respondOk(BlogResource::collection($blogs) , __("blog.index"));
    }

}
