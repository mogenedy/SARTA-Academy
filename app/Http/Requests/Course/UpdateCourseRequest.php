<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'price' => 'numeric|min:0|max:999999.99',
            'online' => 'boolean',
            'live' => 'boolean',
            'institute_id' => 'integer|min:1|exists:institutes,id',
            'start_date' => 'required_with:end_date|nullable|date_format:Y-m-d h:i:s A|after:now',
            'end_date' => 'date_format:Y-m-d h:i:s A|nullable|after:start_date',
            'level' => 'string|in:Beginner,Intermediate,Advanced',
            'user_ids' => 'array|min:1|max:5',
            'user_ids.*' => 'integer|exists:users,id',
            "curriculam" => 'array|min:1|max:1',
            "curriculam.*.points" => 'array|min:1|max:15',
            "what_will_you_learn" => 'array|min:1|max:1',
            "what_will_you_learn.*.points" => 'array|min:1|max:15',
            'category_id' => 'integer|min:1|exists:categories,id',
            "duration" => 'string',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['string', 'max:255'],
                'description.' . $locale => ['string'],
                'certification.' . $locale => ['string'],
                'curriculam.*.description.' . $locale => ['required', 'string'],
                'curriculam.*.points.*.' . $locale => ['required', 'string'],
                'what_will_you_learn.*.description.' . $locale => ['required', 'string'],
                'what_will_you_learn.*.points.*.' . $locale => ['required', 'string'],
            ];
        }

        return $rules;
        
        return [
            'title' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0|max:999999.99',
            'online' => 'boolean',
            'live' => 'boolean',
            'institute_id' => 'integer|min:1|exists:institutes,id',
            'start_date' => 'required_with:end_date|date_format:Y-m-d h:i:s A|after:now',
            'end_date' => 'date_format:Y-m-d h:i:s A|after:start_date',
            'level' => 'string|in:Beginner,Intermediate,Advanced',
            'user_ids' => 'array|min:1|max:5',
            'user_ids.*' => 'required|integer|exists:users,id',
            'certificate' => 'string',
            "curriculam" => 'array|min:1|max:1',
            "curriculam.*.description" => 'required|string',
            "curriculam.*.points" => 'required|array|min:1|max:15',
            "curriculam.*.points.*" => 'required|string',
            "what_will_you_learn" => 'array|min:1|max:1',
            "what_will_you_learn.*.description" => 'required|string',
            "what_will_you_learn.*.points" => 'required|array|min:1|max:15',
            "what_will_you_learn.*.points.*" => 'required|string',
            'category_id' => 'integer|min:1|exists:categories,id',
            "duration" => 'string',
        ];
    }
}
