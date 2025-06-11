<?php

namespace App\Http\Controllers;

use App\Models\ResearcherProfile;
use App\Http\Requests\StoreResearcherProfileRequest;
use App\Http\Requests\UpdateResearcherProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ResearcherProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function storeByAdmin(StoreResearcherProfileRequest $request , User $user)
    {

        if(!$user->hasRole('researcher')){
            return $this->respondError("Can't create Researcher Profile for " . $user->getRoleNames()[0]);    
        }

        $data = $request->validated();
        
        unset($data['image']);
        unset($data['attachment']);

        if ($request->hasFile('attachment')) { 

            $researcherProfile = ResearcherProfile::where('user_id' , $user->id)->first()->clearMediaCollection("main");
            if($researcherProfile){
                
                $researcherProfile->clearMediaCollection("main");
            }
            
            $researcherProfile->addMediaFromRequest('attachment')->toMediaCollection("main");
        }

        $user->researcher_profile()->updateOrCreate(['user_id' => $user->id],$data);
        
        $user->update($data);
        
        if ($request->hasFile('image')) { 
            $user->clearMediaCollection("main");
            $user->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondCreated(UserResource::make($user) , __('researcherProfile.store'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResearcherProfileRequest $request)
    {
        
        $data = $request->validated();
        $user = $request->user;
        
        unset($data['image']);
        unset($data['attachment']);

        if ($request->hasFile('attachment')) { 

            $researcherProfile = ResearcherProfile::where('user_id' , $user->id)->first()->clearMediaCollection("main");
            if($researcherProfile){
                
                $researcherProfile->clearMediaCollection("main");
            }
            
            $researcherProfile->addMediaFromRequest('attachment')->toMediaCollection("main");
        }

        $user->researcher_profile()->updateOrCreate(['user_id' => $user->id],$data);
        
        $user->update($data);
        
        if ($request->hasFile('image')) { 
            $user->clearMediaCollection("main");
            $user->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondCreated(UserResource::make($user) , __('researcherProfile.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ResearcherProfile $researcherProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResearcherProfileRequest $request, ResearcherProfile $researcherProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->user->researcherProfile()->delete();
        return $this->respondNoContent();
    }
}
