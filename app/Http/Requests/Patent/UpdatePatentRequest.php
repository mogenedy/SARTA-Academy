<?php

namespace App\Http\Requests\Patent;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatentRequest extends FormRequest
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
        $rules = [
            'patent_number' => 'integer|min:0',
            'patent_date' => 'date|date_format:Y-m-d H:i:s A',
            'researchers' => 'array|min:2',
            'researchers.*' => 'required|integer|min:1|distinct',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'description.' . $locale => ['string'],
                'title.' . $locale => ['string', 'max:255'],
            ];
        }
    
        return $rules;  
    }
}
