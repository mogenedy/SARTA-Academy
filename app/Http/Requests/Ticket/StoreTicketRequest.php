<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255' , 'phone:EG'],
            'message' => ['required', 'string'],
            'subject' => ['required', 'string', 'max:255'],
            'ticket_type_id' => ['required', 'integer' , 'min:1' , 'exists:ticket_types,id'],
            'institute_id' => ['exists:institutes,id'],
        ];
    }
}
