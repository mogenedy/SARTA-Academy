<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketType\StoreTicketTypeRequest;
use App\Http\Requests\TicketType\UpdateTicketTypeRequest;
use App\Models\TicketType;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticketTypes = TicketType::all('id','title');

        return $this->respondOk($ticketTypes , __('ticketType.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketTypeRequest $request)
    {
        $data = $request->validated();

        $ticketType = TicketType::create($data);

        return $this->respondCreated($ticketType , __('ticketType.store'));

    }

    /**
     * Display the specified resource.
     */
    public function show(TicketType $ticketType)
    {
        return $this->respondOk($ticketType , __('ticketType.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketTypeRequest $request, TicketType $ticketType)
    {
        $data = $request->validated();

        $ticketType->update($data);

        return $this->respondOk($ticketType , __('ticketType.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();

        return $this->respondNoContent();
    }
}
