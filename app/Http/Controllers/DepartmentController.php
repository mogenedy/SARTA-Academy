<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\IndexDepartmentRequest;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexDepartmentRequest $request)
    {
        $data = $request->validated();

        $query = Department::query();

        $query->when(isset($data['sort_by']), function ($query) use ($data) {
            if ($data['asc']) {
                $query->orderBy($data['sort_by']);
            } else {
                $query->orderByDesc($data['sort_by']);
            }
        })->when(isset($data['query']) , function($query) use($data){
            $query->where('title', 'like', '%' . $data['query'] . '%');
        })->when(isset($data['institute_id']) , function($query) use($data){
            $query->where('institute_id' , $data['institute_id']);
        });

        $departments = $query->paginate($data['per_page'] ?? 15);
        
        return $this->respondOk(DepartmentResource::collection($departments) , __('department.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->validated();

        $department = Department::create($data);

        $department->addMediaFromRequest('image')->toMediaCollection("main");

        return $this->respondCreated(DepartmentResource::make($department) , __('department.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->setRelation('researchers' , $department->researchers()->paginate(15));
        return $this->respondOk(DepartmentResource::make($department) , __('department.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $data = $request->validated();

        $department->update($data);

        if ($request->hasFile('image')) { 
            $department->clearMediaCollection("main");
            $department->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk(DepartmentResource::make($department) , __('department.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return $this->respondNoContent();
    }
}
