<?php

namespace App\Http\Requests\Institute;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstitueRequest extends FormRequest
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
            'user_id' => 'integer|min:1|exists:users,id',
            'short_name' => 'string|max:255',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'name.' . $locale => ['string', 'max:255'],
                'vision.' . $locale => ['string'],
                'mission.' . $locale => ['string'],
            ];
        }

        return $rules;
    }
}
