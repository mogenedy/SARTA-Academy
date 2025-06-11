<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Http\Requests\Institute\StoreInstitueRequest;
use App\Http\Requests\Institute\UpdateInstitueRequest;
use App\Http\Resources\InstituteResource;
use App\Models\User;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $institutes = Institute::where('id' , '!=' , 1)->get();
        return $this->respondOk(InstituteResource::collection($institutes), __('institute.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstitueRequest $request)
    {
        $data = $request->validated();

        $user = User::findOrFail($data['user_id']);

        if (!$user) {
            return $this->respondError('User not found');
        }

        if ($user->hasRole('super_admin')) {
            return $this->respondError('Super admin cannot create institue');
        }

        if (!$user->hasRole('admin')) {
            return $this->respondError('institue can only be created for admin');
        }
        
        $institue = Institute::create($data);

        if ($request->hasFile('image')) { 
            $institue->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondCreated($institue, __('institute.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Institute $institute)
    {

        $researchers = User::role('researcher')->whereHas('departments' , function($q) use($institute) {
            $q->where('institute_id' , $institute->id);
        })->paginate();
        
        $institute->setRelation('researchers' , $researchers);
        
        return $this->respondOk(InstituteResource::make($institute->load(['aboutInstitute' , 'departments' , 'user'])), __('institute.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstitueRequest $request, Institute $institute)
    {
        $data = $request->validated();

        if (isset($data['user_id'])){
            $user = User::findOrFail($data['user_id']);

            if ($user->hasRole('super_admin')) {
                return $this->respondError('Super admin cannot create institue');
            }

            if (!$user->hasRole('admin')) {
                return $this->respondError('institue can only be created for admin');
            }
        }
        $institute->update($data);
        
        if ($request->hasFile('image')) { 
            $institute->clearMediaCollection("main");
            $institute->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk($institute, __('institute.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institute $institute)
    {
        if ($institute->id == 1) {
            return $this->respondError("Central Lab can't be deleted.");
        }
        $institute->delete();
        return $this->respondNoContent();
    }
}
