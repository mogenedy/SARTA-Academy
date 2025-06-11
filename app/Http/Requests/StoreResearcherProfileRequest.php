<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResearcherProfileRequest extends FormRequest
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
            'year_of_experience' => 'required|integer',
            'show_email' => 'required|boolean',
            'show_phone' => 'required|boolean',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            'education_qualification' => 'array|size:1',
            'education_qualification.*.points' => 'required|array|min:1',
            'education_qualification.*.points.*.link' => 'required|string',
            'phone' => ['string', 'max:255'],
            'attachment' => 'file|max:2048',
            'linked_in' => ['nullable','string', 'url' , 'max:255' , 'regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/.*$/'],
        ];
            
        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['required', 'string', 'max:255'],
                'name.' . $locale => ['string', 'max:255'],
                'description.' . $locale => ['required', 'string'],
                'biography.' . $locale => ['required', 'string'],
                'education_qualification.*.description.' . $locale => ['required', 'string'],
                'education_qualification.*.points.*.title.' . $locale => ['required', 'string'],
            ];
        }

        return $rules;
    
    }
}
