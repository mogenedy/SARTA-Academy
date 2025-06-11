<?php

namespace App\Http\Requests\Auth;

use App\Rules\MinMaxWordsRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|confirmed|min:8|max:25',
            'email' => 'required|email|unique:users',
            'phone' => ['string', 'phone:SA' , 'max:11'],
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'name.' . $locale => ['required', 'string', 'max:255'],
            ];
        }
        return $rules;       
    }
}
