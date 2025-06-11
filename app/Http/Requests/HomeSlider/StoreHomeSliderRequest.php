<?php

namespace App\Http\Requests\HomeSlider;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeSliderRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'button' => 'required|array|max:1',
            'button.*.link' => 'required|string|max:255',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['required', 'string', 'max:255'],
                'description.' . $locale => ['required', 'string'],
                'button.*.text.' . $locale => ['required', 'string', 'max:255'],
            ];
        }

        return $rules;

    }
}
