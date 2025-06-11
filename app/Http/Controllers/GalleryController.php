<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gallery\StoreGalleryRequest;
use App\Http\Requests\Gallery\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        return $this->respondOk(GalleryResource::collection($galleries) , __('gallery.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();

        $gallery = Gallery::create($data);

        if ($request->hasFile('file')) { 
            $gallery->clearMediaCollection("main");
            $gallery->addMediaFromRequest('file')->toMediaCollection("main");
        }

        return $this->respondOk(GalleryResource::make($gallery), __('gallery.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return $this->respondOk(GalleryResource::make($gallery) ,__('gallery.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        $gallery->update($data);

        if ($request->hasFile('file')) { 
            $gallery->clearMediaCollection("main");
            $gallery->addMediaFromRequest('file')->toMediaCollection("main");
        }

        return $this->respondOk(GalleryResource::make($gallery), __('gallery.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return $this->respondNoContent();
    }
}
