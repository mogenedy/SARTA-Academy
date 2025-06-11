<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\IndexTicketRequest;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexTicketRequest $request)
    {
        $data = $request->validated();

        $query = Ticket::query()->with('ticketType');

        // dd(is_null($data['institute_id']));

        $query->when(isset($data['query']), function($query) use ($data){
            $query->where('name' , 'like' , '%'.$data['query'].'%');
        })->when(isset($data['sort_by']), function($query) use ($data){
            if($data['asc']){
                $query->orderBy($data['sort_by']);
            } else{
                $query->orderByDesc($data['sort_by']);
            }
        })->when(Arr::has($data , 'institute_id') , function($query) use($data){
            $query->where('institute_id' , $data['institute_id']);
        });

        $tickets = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk($tickets , __('ticket.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $data    = $request->validated();

        $ticket = Ticket::create($data);

        $ticket->load('ticketType');
        
        return $this->respondCreated($ticket, __('ticket.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('ticketType');

        return $this->respondOk($ticket , __('ticket.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return $this->respondNoContent();
    }
}
