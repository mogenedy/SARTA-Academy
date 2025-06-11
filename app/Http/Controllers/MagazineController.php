<?php

namespace App\Http\Controllers;

use App\Http\Requests\Magazine\StoreMagazineRequest;
use App\Http\Requests\Magazine\UpdateMagazineRequest;
use App\Http\Resources\MagazineResource;
use App\Models\Magazine;

class MagazineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $magazine = Magazine::paginate(15);

        return $this->respondOk(MagazineResource::collection($magazine)->response()->getData() , __('magazine.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMagazineRequest $request)
    {
        $data = $request->validated();

        $magazine = Magazine::create($data);

        $magazine->addMediaFromRequest('image')->toMediaCollection("main");

        $magazine->addMediaFromRequest('pdf')->toMediaCollection("pdf");

        return $this->respondCreated(MagazineResource::make($magazine) , __('magazine.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Magazine $magazine)
    {
        return $this->respondOk(MagazineResource::make($magazine) , __('magazine.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMagazineRequest $request, Magazine $magazine)
    {
        $data = $request->validated();

        $magazine->update($data);

        if($request->hasFile('image')){
            $magazine->clearMediaCollection("main");
            $magazine->addMediaFromRequest('image')->toMediaCollection("main");
        }

        if($request->hasFile('pdf')){
            $magazine->clearMediaCollection("pdf");
            $magazine->addMediaFromRequest('pdf')->toMediaCollection("pdf");
        }

        return $this->respondOk(MagazineResource::make($magazine) , __('magazine.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Magazine $magazine)
    {
        $magazine->delete();

        return $this->respondNoContent();
    }
}
