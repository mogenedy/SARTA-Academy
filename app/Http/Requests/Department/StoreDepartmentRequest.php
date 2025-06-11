<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'institute_id' => 'required|integer|min:1|exists:institutes,id',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['required', 'string', 'max:255'],
                'description.' . $locale => ['required', 'string'],
                'vision.' . $locale => ['required', 'string'],
                'mission.' . $locale => ['required', 'string'],
            ];
        }
        return $rules;
    }
}
