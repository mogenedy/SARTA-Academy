<?php

namespace App\Http\Requests\PublicationData;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicationDataRequest extends FormRequest
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
            'scopus_link' => 'string|url|max:255|regex:/^(https?:\/\/)?(www\.)?scopus\.com\/.*$/',
            'research_gate_link' => 'string|url|max:255|regex:/^(https?:\/\/)?(www\.)?researchgate\.net\/.*$/',
            'web_of_science_link' => 'string|url|max:255|regex:/^(https?:\/\/)?(www\.)?webofscience\.com\/.*$/',
            'graph' => 'array|min:1',
            'graph.*.record' => 'array|min:1',
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

    public function messages()
    {
        return [
            'scopus_link.regex' => 'The Scopus link must be a valid URL from scopus.com.',
            'research_gate_link.regex' => 'The ResearchGate link must be a valid URL from researchgate.net.',
            'web_of_science_link.regex' => 'The Web of Science link must be a valid URL from webofscience.com.',
        ];
    }
}
