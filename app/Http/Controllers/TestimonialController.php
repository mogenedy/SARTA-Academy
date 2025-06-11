<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Http\Requests\Testimonial\StoreTestimonialRequest;
use App\Http\Requests\Testimonial\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::all();

        return $this->respondOk(TestimonialResource::collection($testimonials) , __('testimonial.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimonialRequest $request)
    {
        $data = $request->validated();

        $testimonial = Testimonial::create($data);

        $testimonial->addMediaFromRequest('image')->toMediaCollection("main");
        
        return $this->respondCreated(TestimonialResource::make($testimonial) , __('testimonial.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $data = $request->validated();

        $testimonial->update($data);

        if ($request->hasFile('image')) { 
            $testimonial->clearMediaCollection("main");
            $testimonial->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk(TestimonialResource::make($testimonial) , __('testimonial.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return $this->respondNoContent();
    }
}
