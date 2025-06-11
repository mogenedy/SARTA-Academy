<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogTag\StoreBlogTagRequest;
use App\Http\Requests\BlogTag\UpdateBlogTagRequest;
use App\Http\Resources\BlogTagResource;
use App\Models\BlogTag;

class BlogTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = BlogTag::all();

        return $this->respondOk(BlogTagResource::collection($tags) , __("blogTag.index"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogTagRequest $request)
    {
        $data = $request->validated();

        $blogTag = BlogTag::create($data);

        return $this->respondCreated(BlogTagResource::make($blogTag) , __("blogTag.store"));
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogTag $blogTag)
    {
        $blogTag->setRelation('blogs' , $blogTag->blogs()->paginate(15));
        return $this->respondOk(BlogTagResource::make($blogTag) , __("blogTag.show"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogTagRequest $request, BlogTag $blogTag)
    {
        $data = $request->validated();

        $blogTag->update($data);

        return $this->respondOk(BlogTagResource::make($blogTag) , __("blogTag.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogTag $blogTag)
    {
        $blogTag->delete();

        return $this->respondNoContent();
    }

    public function getPopularTags(){
       
        $blogs = BlogTag::inRandomOrder()->take(6)->get();
        return $this->respondOk(BlogTagResource::collection($blogs) , __("blogTag.index"));
    }
}
