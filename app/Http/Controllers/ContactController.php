<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::all();

        return $this->respondOk(ContactResource::collection($contacts) , __('contact.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();

        $contact = Contact::create($data);

        return $this->respondCreated(ContactResource::make($contact)  , __('contact.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return $this->respondOk(ContactResource::make($contact) , __('contact.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $data = $request->validated();

        $contact->update($data);

        return $this->respondOk(ContactResource::make($contact) , __('contact.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy(Contact $contact)
    {
        $contact->delete();

        return $this->respondNoContent();
    }
}
