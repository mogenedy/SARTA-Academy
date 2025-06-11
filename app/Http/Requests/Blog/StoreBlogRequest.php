<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'blog_category_id' => 'required|min:1|exists:blog_categories,id',
            'events' => 'array|min:1|max:5',
            'events.*' => ['required', 'integer','min:1', 'exists:events,id'],
            'tags' => 'required|array|min:1',
            'tags.*' => ['required', 'integer','min:1', 'exists:blog_tags,id'],
        ];

        foreach (config('app.locales') as $locale) {
            $rules += [
                'title.' . $locale => ['required', 'string', 'max:255'],
                'description.' . $locale => ['required', 'string'],
            ];
        }

        return $rules;
    }
}
