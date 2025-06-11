<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeCounter\UpdateHomeCounterRequest;
use App\Models\HomeCounter;
use App\Http\Resources\AboutHomeResource;
use App\Http\Resources\HomeCounterResource;
use Illuminate\Http\Request;

class HomeCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homeCounters = HomeCounter::all();
        return $this->respondOk(HomeCounterResource::collection($homeCounters), __('homeCounter.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeCounter $aboutHome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHomeCounterRequest $request, HomeCounter $homeCounter)
    {
        $data = $request->validated();

        $homeCounter->update($data);

        return $this->respondOk(HomeCounterResource::make($homeCounter), __('homeCounter.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeCounter $aboutHome)
    {
        //
    }
}
