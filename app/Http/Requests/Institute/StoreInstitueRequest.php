<?php

namespace App\Http\Requests\Institute;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitueRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'user_id' => 'required|integer|min:1|exists:users,id',
            'short_name' => 'required|string|max:255',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'name.' . $locale => ['required', 'string', 'max:255'],
                'vision.' . $locale => ['required', 'string'],
                'mission.' . $locale => ['required', 'string'],
            ];
        }

        return $rules;

    }
}
