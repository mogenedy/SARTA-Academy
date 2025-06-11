<?php

namespace App\Http\Requests\AboutInstitute;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutInstituteRequest extends FormRequest
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
            'institute_id' => 'integer|min:1|exists:institutes,id',
            'images' => 'array|size:2',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['string', 'max:255'],
                'description.' . $locale => ['string'],
            ];
        }

        return $rules;
        
    }
}
