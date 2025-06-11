<?php

namespace App\Http\Controllers;

use App\Http\Requests\CentralLab\StoreCentralLabRequest;
use App\Http\Requests\CentralLab\UpdateCentralLabRequest;
use App\Models\CentralLab;

class CentralLabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centralLabs = CentralLab::all();

        return $this->respondOk($centralLabs , __("centralLab.index"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCentralLabRequest $request)
    {
        $data = $request->validated();

        $centralLab = CentralLab::create($data);

        if ($request->hasFile('image')) { 
            $centralLab->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondCreated($centralLab , __("centralLab.store"));
    }

    /**
     * Display the specified resource.
     */
    public function show(CentralLab $centralLab)
    {
        return $this->respondOk($centralLab , __("centralLab.show"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCentralLabRequest $request, CentralLab $centralLab)
    {
        $data = $request->validated();

        $centralLab->update($data);

        if ($request->hasFile('image')) { 
            $centralLab->clearMediaCollection("main");
            $centralLab->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk($centralLab , __("centralLab.update"));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CentralLab $centralLab)
    {
        $centralLab->delete();

        return $this->respondNoContent();
    }
}
