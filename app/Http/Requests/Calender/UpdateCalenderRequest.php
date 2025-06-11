<?php

namespace App\Http\Requests\Calender;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalenderRequest extends FormRequest
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
            'type' => 'required_with:event_id,course_id,blog_id|integer|min:1|in:Event,Course,Blog,General',
            'event_id' => 'required_if:type,Event|integer|min:1|exists:events,id',
            'course_id' => 'required_if:type,Course|integer|min:1|exists:courses,id',
            'blog_id' => 'required_if:type,Blog|integer|min:1|exists:blogs,id',
            'starts_at' => 'date_format:Y-m-d h:i:s A|after:now',
            'ends_at' => 'date_format:Y-m-d h:i:s A|after:starts_at',
            'institute_id' => 'nullable|integer|min:1|exists:institutes,id',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['string', 'max:255'],
            ];
        }

        return $rules;
    }
}
