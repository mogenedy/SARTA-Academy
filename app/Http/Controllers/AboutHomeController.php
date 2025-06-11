<?php

namespace App\Http\Controllers;

use App\Models\AboutHome;
use App\Http\Requests\AboutHome\StoreAboutHomeRequest;
use App\Http\Requests\AboutHome\UpdateAboutHomeRequest;
use App\Http\Resources\AboutHomeResource;

class AboutHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutHome = AboutHome::first();
        return $this->respondOk(AboutHomeResource::make($aboutHome), __('aboutHome.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAboutHomeRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutHome $aboutHome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutHomeRequest $request, AboutHome $aboutHome)
    {
        $data = $request->validated();

        $aboutHome->update($data);

        if ($request->hasFile('image')) { 
            $aboutHome->clearMediaCollection("main");
            $aboutHome->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk(AboutHomeResource::make($aboutHome), __('aboutHome.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutHome $aboutHome)
    {
        //
    }
}
