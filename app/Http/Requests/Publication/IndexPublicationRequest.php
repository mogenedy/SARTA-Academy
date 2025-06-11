<?php

namespace App\Http\Requests\Publication;

use Illuminate\Foundation\Http\FormRequest;

class IndexPublicationRequest extends FormRequest
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
            'query' => 'string',
            'researchers' => 'array|min:1',
            'researchers.*' => 'required|integer|min:1|distinct',
            'year_from' => 'integer|min:1900|max:'.(date('Y')+1),
            'year_to' => 'integer|after_or_equal:year_from',
            'sort_by' => 'string|in:id,title,year', 
            'asc' => 'boolean|required_with:sort_by',
            'per_page' => 'integer|min:1|max:30',
        ];
    }
}
