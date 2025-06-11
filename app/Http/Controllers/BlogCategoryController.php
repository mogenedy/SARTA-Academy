<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogCategory\StoreBlogCategoryRequest;
use App\Http\Requests\BlogCategory\UpdateBlogCategoryRequest;
use App\Http\Resources\BlogCategoryResource;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogCategories  = BlogCategory::all();

        return $this->respondOk(BlogCategoryResource::collection($blogCategories) , __("blogCategory.index"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        $data = $request->validated();

        $blogCategory = BlogCategory::create($data);

        return $this->respondCreated(BlogCategoryResource::make($blogCategory) , __("blogCategory.store"));
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory)
    {
        $blogCategory->setRelation('blogs' , $blogCategory->blogs()->paginate(15));
        return $this->respondOk(BlogCategoryResource::make($blogCategory) , __("blogCategory.show"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $data = $request->validated();

        $blogCategory->update($data);

        return $this->respondOk(BlogCategoryResource::make($blogCategory) , __("blogCategory.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return  $this->respondNoContent();
    }
}
