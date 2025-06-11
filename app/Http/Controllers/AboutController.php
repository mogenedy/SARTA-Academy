<?php

namespace App\Http\Controllers;

use App\Http\Requests\About\StoreAboutRequest;
use App\Http\Requests\About\UpdateAboutRequest;
use App\Http\Resources\AboutResource;
use App\Models\About;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = About::first();
        return $this->respondOk(AboutResource::make($about), __('about.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAboutRequest $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutRequest $request, About $about)
    {
        $data = $request->validated();

        $about->update($data);

        if ($request->hasFile('image')) { 
            $about->clearMediaCollection("main");
            $about->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk(AboutResource::make($about), __("about.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        //
    }
}
