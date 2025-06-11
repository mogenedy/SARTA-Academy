<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class IndexEventRequest extends FormRequest
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
            'query' => ['string'  , 'max:255'],
            'per_page' => 'integer|min:1|max:30',
            'sort_by' => 'string|in:id,title,date',
            'asc' => 'boolean|required_with:sort_by',
            'by_time' => 'string|in:upcoming,previous',
        ];
    }
}
