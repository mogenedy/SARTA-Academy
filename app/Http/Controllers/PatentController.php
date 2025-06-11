<?php

namespace App\Http\Controllers;

use App\Http\Requests\Patent\IndexPatentRequest;
use App\Http\Requests\Patent\StorePatentRequest;
use App\Http\Requests\Patent\UpdatePatentRequest;
use App\Http\Resources\PatentResource;
use App\Models\Patent;
use App\Models\User;

class PatentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPatentRequest $request)
    {
        $data = $request->validated();

        $query = Patent::query()->with('researchers');

        $query->when(isset($data['query']), function ($query) use ($data) {

            $query->where('title', 'like', '%' . $data['query'] . '%')->orWhere('patent_number', 'like', '%' . $data['query'] . '%');

        })->when(isset($data['researchers']), function ($query) use ($data) {

            $query->whereHas('researchers', function ($query) use ($data) {

                $query->whereIn('id', $data['researchers']);

            });

        })->when(isset($data['patent_number']), function ($query) use ($data) {

            $query->where('patent_number', $data['patent_number']);

        })->when(isset($data['patent_date_from']), function ($query) use ($data) {

            $query->where('patent_date', '>=', $data['patent_date_from']);

        })->when(isset($data['patent_date_to']), function ($query) use ($data) {

            $query->where('patent_date', '<=', $data['patent_date_to']);

        })->when(isset($data['sort_by']), function ($query) use ($data){

            $query->orderBy($data['sort_by'], $data['asc'] ? 'asc' : 'desc');

        });

        $patents = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(PatentResource::collection($patents)->response()->getData() , __('patent.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatentRequest $request)
    {
        $data = $request->validated();

        $patent = Patent::create($data);

        $users = User::role('researcher')->whereIn('id', $data['researchers'])->get();

        if (count($users) != count($data['researchers'])) {
            return $this->respondError("all selected users must be a researcher");
        }

        $patent->researchers()->sync($data['researchers']);
        $patent->load('researchers');

        return $this->respondCreated(PatentResource::make($patent) , __('patent.store'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Patent $patent)
    {
        return $this->respondOk(PatentResource::make($patent->load('researchers')) , __('patent.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatentRequest $request, Patent $patent)
    {
        $data = $request->validated();

        $patent->update($data);

        
        if (isset($data['researchers'])) {

            $users = User::role('researcher')->whereIn('id', $data['researchers'])->get();

            if (count($users) != count($data['researchers'])) {
                return $this->respondError("all selected users must be a researcher");
            }

            $patent->researchers()->sync($data['researchers']);
        }

        $patent->load('researchers');

        return $this->respondOk(PatentResource::make($patent) , __('patent.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patent $patent)
    {
        $patent->delete();
        return $this->respondNoContent();
    }
}
