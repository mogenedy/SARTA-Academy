<?php

namespace App\Http\Requests\About;

use Illuminate\Foundation\Http\FormRequest;

class StoreAboutRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'title' => 'required|string|max:255',
            'vision' => 'required|array',
            'mission' => 'required|array',
            'objectives' => 'required|array',
            'vision.*' => 'required|string',
            'mission.*' => 'required|string',
            'objectives.*' => 'required|string',
        ];
        
        // Fields to be made translatable
        $translatableFields = ['description', 'title', 'vision.*', 'mission.*', 'objectives.*'];
        
        // Make the fields translatable
        $rules = makeFieldsTranslatable($rules, $translatableFields);
        
        // Return the rules
        return $rules;
    }
}
