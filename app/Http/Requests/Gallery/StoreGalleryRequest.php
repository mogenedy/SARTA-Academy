<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            'file' => 'required_without:link|mimes:jpeg,png,jpg,mp4,mkv|max:15242',
            'link' => 'required_without:file|string|max:255',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['required', 'string', 'max:255'],
            ];
        }

        return $rules;
    }
}
