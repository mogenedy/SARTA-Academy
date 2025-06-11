<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeSlider\StoreHomeSliderRequest;
use App\Http\Requests\HomeSlider\UpdateHomeSliderRequest;
use App\Models\HomeSlider;
use App\Http\Resources\HomeSliderResource;

class HomeSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeSliders = HomeSlider::all();
        return $this->respondOk(HomeSliderResource::collection($homeSliders) , __('homeSlider.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomeSliderRequest $request)
    {
        $data = $request->validated();

        $homeSlider = HomeSlider::create($data);

        $homeSlider->addMediaFromRequest('image')->toMediaCollection("main");

        return $this->respondCreated(HomeSliderResource::make($homeSlider) , __('homeSlider.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSlider $homeSlider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHomeSliderRequest $request, HomeSlider $homeSlider)
    {
        $data = $request->validated();

        $homeSlider->update($data);
        
        if ($request->hasFile('image')) { 
            $homeSlider->clearMediaCollection("main");
            $homeSlider->addMediaFromRequest('image')->toMediaCollection("main");
        }
        
        return $this->respondOk(HomeSliderResource::make($homeSlider) , __('homeSlider.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSlider $homeSlider)
    {
        $homeSlider->delete();

        return $this->respondNoContent();
    }
}
