<?php

namespace App\Http\Requests\Calender;

use Illuminate\Foundation\Http\FormRequest;

class IndexCalenderRequest extends FormRequest
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
            'type' => 'string|max:255|in:Course,Event,Blog,General',
            'from' => 'date_format:Y-m-d',
            'to' => 'date_format:Y-m-d|after:from',
            'institute_id' => 'integer|min:1|exists:institutes,id',
        ];
    }
}
