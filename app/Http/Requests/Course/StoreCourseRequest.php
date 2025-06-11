<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'price' => 'required|numeric|min:0|max:999999.99',
            'online' => 'required|boolean',
            'live' => 'required|boolean',
            'institute_id' => 'required|integer|min:1|exists:institutes,id',
            'user_ids' => 'required|array|min:1|max:5',
            'user_ids.*' => 'required|integer|exists:users,id',
            'start_date' => 'required_with:end_date|date_format:Y-m-d h:i:s A|after:now',
            'end_date' => 'date_format:Y-m-d h:i:s A|after:start_date',
            'level' => 'required|string|in:Beginner,Intermediate,Advanced',
            "curriculam" => 'required|array|min:1|max:1',
            "curriculam.*.points" => 'array|min:1|max:15',
            "what_will_you_learn" => 'array|required|min:1|max:1',
            "what_will_you_learn.*.points" => 'array|min:1|max:15',
            'category_id' => 'required|integer|min:1|exists:categories,id',
            "duration" => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['required', 'string', 'max:255'],
                'description.' . $locale => ['required', 'string'],
                'certification.' . $locale => ['required', 'string'],
                'curriculam.*.description.' . $locale => ['required', 'string'],
                'curriculam.*.points.*.' . $locale => ['required', 'string'],
                'what_will_you_learn.*.description.' . $locale => ['required', 'string'],
                'what_will_you_learn.*.points.*.' . $locale => ['required', 'string'],
            ];
        }

        return $rules;

    }
}
