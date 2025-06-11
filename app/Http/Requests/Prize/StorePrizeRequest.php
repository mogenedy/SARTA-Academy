<?php

namespace App\Http\Requests\Prize;

use Illuminate\Foundation\Http\FormRequest;

class StorePrizeRequest extends FormRequest
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
            'year' => 'required|integer|between:1900,'.date('Y'),
            'researcher_id' => 'required_without:researcher_name|integer|exists:users,id',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [ 
                'title.' . $locale => ['required', 'string' , 'max:255'],
                'researcher_name.' . $locale => ['required_without:researcher_id', 'string' , 'max:255'],
            ];
        }

        return $rules;
    }
}
