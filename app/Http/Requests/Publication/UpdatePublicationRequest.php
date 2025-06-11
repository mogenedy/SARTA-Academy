<?php

namespace App\Http\Requests\Publication;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicationRequest extends FormRequest
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
            'journal' => 'array|size:1',
            'journal.*.link' => 'required|string',
            'year' => 'digits:4|integer|min:1900|max:'.(date('Y')+1),
            'researchers' => 'array|min:1|max:10',
            'researchers.*' => 'required|integer|min:1|distinct',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['string'],
                'journal.*.title.' . $locale => 'required|string',
            ];
        }
    
        return $rules;  
    }
}
