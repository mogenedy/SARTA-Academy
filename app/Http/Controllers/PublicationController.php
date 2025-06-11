<?php

namespace App\Http\Controllers;

use App\Http\Requests\Publication\IndexPublicationRequest;
use App\Http\Requests\Publication\StorePublicationRequest;
use App\Http\Requests\Publication\UpdatePublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use App\Models\User;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPublicationRequest $request)
    {
        $data = $request->validated();

        $query = Publication::query()->with('researchers');

        $query->when(isset($data['query']), function ($query) use ($data) {
            $query->where('title', 'like', '%'.$data['query'].'%');
        })->when(isset($data['researchers']), function ($query) use ($data) {

            $query->whereHas('researchers', function ($query) use ($data) {

                $query->whereIn('id', $data['researchers']);

            });

        })->when(isset($data['year_from']), function ($query) use ($data) {

            $query->where('year', '>=', $data['year_from']);

        })->when(isset($data['year_to']), function ($query) use ($data) {

            $query->where('year', '<=', $data['year_to']);

        })->when(isset($data['sort_by']), function ($query) use ($data){

            $query->orderBy($data['sort_by'], $data['asc'] ? 'asc' : 'desc');

        });

        $publications = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(PublicationResource::collection($publications)->response()->getData() , __('publication.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublicationRequest $request)
    {
        $data = $request->validated();

        $users = User::role('researcher')->whereIn('id', $data['researchers'])->get();

        if (count($users) != count($data['researchers'])) {
            return $this->respondError("all selected users must be a researcher");
        }

        $publication = Publication::create($data);

        $publication->researchers()->sync($data['researchers']);

        return $this->respondCreated(PublicationResource::make($publication->load('researchers')) , __('publication.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication)
    {
        return $this->respondOk(PublicationResource::make($publication->load('researchers')) , __('publication.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublicationRequest $request, Publication $publication)
    {
        $data = $request->validated();

        if (isset($data['researchers'])) {

            $users = User::role('researcher')->whereIn('id', $data['researchers'])->get();

            if (count($users) != count($data['researchers'])) {
                return $this->respondError("all selected users must be a researcher");
            }

            $publication->researchers()->sync($data['researchers']);
        }

        $publication->update($data);

        return $this->respondOk(PublicationResource::make($publication->load('researchers')) , __('publication.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication)
    {
        $publication->delete();

        return $this->respondNoContent();
    }
}
