<?php

namespace App\Http\Requests\Prize;

use Illuminate\Foundation\Http\FormRequest;

class IndexPrizeRequest extends FormRequest
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
            'researcher_id' => ['integer', 'min:1', 'exists:users,id'],
            'sort_by' => 'string|in:id,title,year',
            'asc' => 'boolean|required_with:sort_by',
            'per_page' => 'integer|min:1|max:30',
            'year' => 'integer|between:1900,'.date('Y'),
        ];
    }
}
