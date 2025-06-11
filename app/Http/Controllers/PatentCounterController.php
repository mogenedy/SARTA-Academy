<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatentCounter\StorePatentCounterRequest;
use App\Http\Requests\PatentCounter\UpdatePatentCounterRequest;
use App\Http\Resources\PatentCounterResource;
use App\Models\PatentCounter;

class PatentCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patentCounter = PatentCounter::first();
        return $this->respondOk(PatentCounterResource::make($patentCounter) , __('patentCounter.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatentCounterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PatentCounter $patentCounter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatentCounterRequest $request, PatentCounter $patentCounter)
    {
        $data = $request->validated();

        $patentCounter->update($data);

        return $this->respondOk(PatentCounterResource::make($patentCounter) , __('patentCounter.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatentCounter $patentCounter)
    {
        //
    }
}
