<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'starts_at' => 'date_format:Y-m-d h:i:s A|before:ends_at',
            'ends_at' => 'date_format:Y-m-d h:i:s A|after:starts_at',
            'researchers' => 'array|min:2|max:10',
            'researchers.*' => 'required|integer|min:1|distinct',
            'department_id' => 'integer|min:1|exists:departments,id',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['string', 'max:255'],
                'finance.' . $locale => ['string', 'max:255'],
                'duration.' . $locale => ['string', 'max:255'],
                'description.' . $locale => ['string'],
                'objectives.' . $locale => ['string'],
                'deliverables.' . $locale => ['string'],
                'beneficaries.' . $locale => ['string'],
            ];
        }

        return $rules;
    }
}
