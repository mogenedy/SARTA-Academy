<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'description' => 'array|size:1',
            'what_will_you_learn' => 'array|size:1',
            'what_will_you_learn.*.points' => 'required|array|min:1',
            'date' => 'date|date_format:Y-m-d H:i:s A|after:now',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
            'phone' => 'string|phone:EG',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'blogs' => 'array|min:1|max:5',
            'blogs.*' => ['required', 'integer','min:1', 'exists:blogs,id'],
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['string', 'max:255'],
                'description.*.title.' . $locale => ['required', 'string', 'max:255'],
                'description.*.description.' . $locale => ['required', 'string'],
                'what_will_you_learn.*.title.' . $locale => ['required', 'string', 'max:255'],
                'what_will_you_learn.*.points.*.' . $locale => ['required', 'string', 'max:255'],
            ];
        }
        return $rules;   
    }
}
