<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\ShowAdminCategoryRequest;
use App\Http\Requests\Category\ShowCategoryRequest;
use App\Http\Requests\Category\ShowSubCategoryRequest;
use App\Models\Category;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Course;
use App\Models\Product;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate();
        return $this->respondOk(CategoryResource::collection($categories), __('category.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        
        return $this->respondCreated(CategoryResource::make($category), __('category.store'));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category , ShowCategoryRequest $request)
    {
        $data = $request->validated();
        $perPage = $data['per_page'] ?? 15;

        $query = Course::query()->isLive(true)->where('category_id' , $category->id);

        $query->when(isset($data['query']) , function($query) use($data){
            $query->where('title' , 'like' , '%'.$data['query'].'%'); 
         })
         ->when(isset($data['sort_by']) , function($query) use($data){
             if($data['asc']){
                 $query->orderBy($data['sort_by']);
             } else{
                 $query->orderByDesc($data['sort_by']);
             }
         });

        $category->getTranslations();
        $category->courses = $query->paginate($perPage);
        return $this->respondOk(CategoryResource::make($category), __('category.show'));
    }

    /**
     * Display the specified resource for admin.
     */
    public function show_admin(Category $category , ShowAdminCategoryRequest $request)
    {
        $data = $request->validated();
        $perPage = $data['per_page'] ?? 15;

        $query = Course::query()->where('category_id' , $category->id);

        $query->when(isset($data['live']) , function($query) use($data){
            $query->isLive($data['live']);
         })->when(isset($data['query']) , function($query) use($data){
            $query->where('title' , 'like' , '%'.$data['query'].'%'); 
         })
         ->when(isset($data['sort_by']) , function($query) use($data){
             if($data['asc']){
                 $query->orderBy($data['sort_by']);
             } else{
                 $query->orderByDesc($data['sort_by']);
             }
         });

        $category->courses = $query->paginate($perPage);

        return $this->respondOk(CategoryResource::make($category), __('category.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        
        $category->update($request->validated());

        return $this->respondOk(CategoryResource::make($category), __('category.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->respondNoContent();
    }
}
