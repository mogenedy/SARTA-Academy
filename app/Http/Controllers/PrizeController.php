<?php

namespace App\Http\Controllers;

use App\Http\Requests\Prize\IndexPrizeRequest;
use App\Http\Requests\Prize\StorePrizeRequest;
use App\Http\Requests\Prize\UpdatePrizeRequest;
use App\Http\Resources\PrizeResource;
use App\Models\Prize;
use App\Models\User;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPrizeRequest $request)
    {
        $data = $request->validated();

        $query = Prize::query()->with('researcher');

        $query->when(!empty($data['query']), function ($q) use ($data) {
            return $q->where('title', '%' . $data['query'] . '%');
        })
        ->when(isset($data['year']), function ($q) use ($data) {
            return $q->where('year', $data['year']);
        })->when(isset($data['sort_by']), function($query) use ($data){
            if($data['asc']){
                $query->orderBy($data['sort_by']);
            } else{
                $query->orderByDesc($data['sort_by']);
            }
        });

        $prizes = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(PrizeResource::collection($prizes)->response()->getData() , __('prize.index'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrizeRequest $request)
    {
        $data = $request->validated();

        if(isset($data['researcher_id'])){
            $researcher = User::find($data['researcher_id']);

            if(!$researcher->hasRole('researcher')){
                return $this->respondError("Selected user must be a researcher");
            }
        }

        $prize = Prize::create($data);

        return $this->respondCreated(PrizeResource::make($prize->load('researcher')) , __('prize.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Prize $prize)
    {
        return $this->respondOk(PrizeResource::make($prize->load('researcher')) , __('prize.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrizeRequest $request, Prize $prize)
    {
        $data = $request->validated();

        if(isset($data['researcher_id'])){
            $researcher = User::find($data['researcher_id']);

            if(!$researcher->hasRole('researcher')){
                return $this->respondError("Selected user must be a researcher");
            }
        }
        
        $prize->update($data);

        return $this->respondOk(PrizeResource::make($prize->load('researcher')) , __('prize.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prize $prize)
    {
        $prize->delete();

        return $this->respondNoContent();
    }
}
