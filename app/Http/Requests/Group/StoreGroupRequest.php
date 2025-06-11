<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'is_main' => 'required|boolean',
            'expires_at' => 'date_format:Y-m-d h:i:s A|after:now',
            'max_users' => 'integer|min:1|max:999999',
            'live' => 'required|boolean',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'name.' . $locale => ['required', 'string', 'max:255'],
            ];
        }

        return $rules;

    }
}
