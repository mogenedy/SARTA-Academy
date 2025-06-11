<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class IndexAdminCourseRequest extends FormRequest
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
        return [
            'query' => 'string|max:255',
            'state' => 'string|in:active,expired,upcoming',
            'live' => 'boolean',
            'institute_id' => 'integer|min:1|exists:institutes,id',
            'user_id' => 'integer|min:1|exists:users,id',
            'per_page' => 'integer|min:1|max:30',
            'sort_by' => 'string|in:id,title,price,',
            'asc' => 'boolean|required_with:sort_by',
            'online' => 'boolean',
            'category_id' => 'integer|min:1|exists:categories,id',
            'price' => 'string|in:free,paid',
            'researchers' => 'array|min:1',
            'researchers.*' => 'integer|min:1|exists:users,id'
        ];
    }
}
