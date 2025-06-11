<?php

namespace App\Http\Requests\PublicationData;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicationDataRequest extends FormRequest
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
            'scopus_link' => 'required|string',
            'research_gate_link' => 'required|string',
            'web_of_science_link' => 'required|string',
            'graph' => 'required|array|min:1',
            'graph.*.record' => 'required|array|min:1',
            'graph.*.record.*.year' => 'required|string',
            'graph.*.record.*.number' => 'required|integer',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'graph.*.title.' . $locale => ['required', 'string'],
            ];
        }
    
        return $rules;
    }
}
