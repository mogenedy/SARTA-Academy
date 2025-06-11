<?php

namespace App\Http\Requests\Testimonial;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
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
            'image' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'name.' . $locale => ['string', 'max:255'],
                'description.' . $locale => ['string'],
                'position.' . $locale => ['string' ,'max:255'],
            ];
        }

        return $rules;
    }
}
