<?php

namespace App\Http\Requests\About;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest
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
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'vision' => 'array|min:1',
            'mission' => 'array|min:1',
            'objectives' => 'array|min:1',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['string', 'max:255'],
                'description.' . $locale => ['string'],
                'vision.*.' . $locale => ['required', 'string'],
                'mission.*.' . $locale => ['required', 'string'],
                'objectives.*.' . $locale => ['required', 'string'],
            ];
        }

        return $rules;
    }
}
