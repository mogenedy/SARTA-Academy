<?php

namespace App\Http\Requests\Patent;

use Illuminate\Foundation\Http\FormRequest;

class IndexPatentRequest extends FormRequest
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
            'query' => 'string|max:255',
            'researchers' => 'array|min:1',
            'researchers.*' => 'required|integer|min:1|distinct',
            'patent_date_from' => 'date|date_format:Y-m-d H:i:s A',
            'patent_date_to' => 'date|date_format:Y-m-d H:i:s A|after:patent_date_from',
            'sort_by' => 'string|in:id,patent_number',
            'asc' => 'boolean|required_with:sort_by',
            'per_page' => 'integer|min:1|max:30',
        ];
    }
}
