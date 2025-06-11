<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class IndexTicketRequest extends FormRequest
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
            'query' => ['string' , 'max:255'],
            'institute_id' => ['nullable','integer', 'min:1', 'exists:institutes,id'],
            'sort_by' => 'string|in:id,name',
            'asc' => 'boolean|required_with:sort_by',
            'per_page' => 'integer|min:1|max:30',
        ];
    }
}
