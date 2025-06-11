<?php

namespace App\Http\Controllers;

use App\Models\AboutHome;
use App\Http\Requests\AboutInstitute\StoreAboutInstituteRequest;
use App\Http\Requests\AboutInstitute\UpdateAboutInstituteRequest;
use App\Http\Resources\AboutHomeResource;
use App\Http\Resources\AboutInstituteResource;
use App\Models\AboutInstitute;

class AboutInstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $aboutHome = AboutInstitute::first();
        // return $this->respondOk(AboutHomeResource::make($aboutHome), __('aboutHome.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAboutInstituteRequest $request)
    {
        $data = $request->validated();

        if (AboutInstitute::where('institute_id', $data['institute_id'])->exists()) {
            return $this->respondError("About Institute Already Exists", 422);
        }
        
        $aboutInstitute = AboutInstitute::create($data);

        if ($request->hasFile('images')) {
            $aboutInstitute
                ->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection("images");
                });
        }

        return $this->respondCreated(AboutInstituteResource::make($aboutInstitute), __('aboutInstitute.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutInstitute $aboutInstitute)
    {
        return $this->respondOk(AboutInstituteResource::make($aboutInstitute), __('aboutInstitute.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutInstituteRequest $request, AboutInstitute $aboutInstitute)
    {
        $data = $request->validated();

        $aboutInstitute->update($data);
        
        if ($request->hasFile('images')) {
            $aboutInstitute->clearMediaCollection("images");
            $aboutInstitute->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection("images");
                });
        }


        return $this->respondOk(AboutInstituteResource::make($aboutInstitute), __('aboutInstitute.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutInstitute $aboutInstitute)
    {
        $aboutInstitute->delete();
        return $this->respondNoContent();
    }
}
