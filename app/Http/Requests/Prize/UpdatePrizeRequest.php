<?php

namespace App\Http\Requests\Prize;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrizeRequest extends FormRequest
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
            'year' => 'integer|between:1900,'.date('Y'),
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [ 
                'title.' . $locale => ['string' , 'max:255'],
            ];
        }

        return $rules;
    }
}
