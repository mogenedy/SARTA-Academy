<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\IndexProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexProjectRequest $request)
    {
        $data =  $request->validated();
        
        $query  = Project::query()->with('researchers' , 'department');

        $query->when(isset($data['query']), function($query) use ($data){
            $query->where('title' , 'like' , '%'.$data['query'].'%');
        })->when(isset($data['sort_by']), function($query) use ($data){
            if($data['asc']){
                $query->orderBy($data['sort_by']);
            } else{
                $query->orderByDesc($data['sort_by']);
            }
        })->when(isset($data['researcher_id']) , function($query) use($data){
            $query->where('researcher_id' , $data['researcher_id']);
        })->when(isset($data['department_id']) , function($query) use($data){
            $query->where('department_id' , $data['department_id']);
        })->when(isset($data['institute_id']) , function($query) use($data){
            $query->whereHas('department', function($query) use ($data) {
                $query->where('institute_id', $data['institute_id']);
            });
        });

        $projects = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(ProjectResource::collection($projects)->response()->getData() , __("project.index"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        
        $users = User::role('researcher')->whereIn('id', $data['researchers'])->get();

        if (count($users) != count($data['researchers'])) {
            return $this->respondError("all selected users must be a researcher");
        }
        
        $project = Project::create($data);

        if($request->hasFile('image')){
            $project->addMediaFromRequest('image')->toMediaCollection("main");
        }

        $project->researchers()->sync($data['researchers']);

        $project->load('department');
        $project->load('researchers');

        return $this->respondCreated(ProjectResource::make($project) , __('project.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['researchers' , 'department']);
        return $this->respondOk(ProjectResource::make($project) , __('project.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if (isset($data['researchers'])) {

            $users = User::role('researcher')->whereIn('id', $data['researchers'])->get();

            if (count($users) != count($data['researchers'])) {
                return $this->respondError("all selected users must be a researcher");
            }

            $project->researchers()->sync($data['researchers']);
        }

        $project->update($data);

        if($request->hasFile('image')){
            $project->clearMediaCollection("main");
            $project->addMediaFromRequest('image')->toMediaCollection("main");
        }

        $project->load('department');
        $project->load('researchers');

        return $this->respondOk(ProjectResource::make($project) , __('project.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return $this->respondNoContent();
    }
}
