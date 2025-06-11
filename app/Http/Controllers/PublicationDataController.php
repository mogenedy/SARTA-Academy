<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicationData\StorePublicationDataRequest;
use App\Http\Requests\PublicationData\UpdatePublicationDataRequest;
use App\Models\PublicationData;

class PublicationDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publicationData = PublicationData::all();
        
        return $this->respondOk($publicationData , __(' publication.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublicationDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PublicationData $publicationData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublicationDataRequest $request, PublicationData $publicationDatum)
    {
        $data = $request->validated();

        $publicationDatum->update($data);

        return $this->respondOk($publicationDatum , __('publication.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublicationData $publicationData)
    {
        //
    }
}
