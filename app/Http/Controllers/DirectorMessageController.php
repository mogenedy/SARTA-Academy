<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectorMessage\StoreDirectorMessageRequest;
use App\Http\Requests\DirectorMessage\UpdateDirectorMessageRequest;
use App\Http\Resources\DirectorMessageResource;
use App\Models\About;
use App\Models\DirectorMessage;

class DirectorMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = DirectorMessage::first();
        return $this->respondOk(DirectorMessageResource::make($about), __('directorMessage.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDirectorMessageRequest $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(DirectorMessage $about)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDirectorMessageRequest $request, DirectorMessage $directorMessage)
    {
        $data = $request->validated();

        $directorMessage->update($data);

        if ($request->hasFile('image')) { 
            $directorMessage->clearMediaCollection("main");
            $directorMessage->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk(DirectorMessageResource::make($directorMessage), __("directorMessage.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(About $about)
    {
        //
    }
}
