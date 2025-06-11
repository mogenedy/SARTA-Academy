<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleRequest extends FormRequest
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
            'role' => 'required|string|in:client,researcher,admin,editor',
            'institute_id' => 'required_if:role,editor|integer|min:1|exists:institutes,id',
            'department_id' => 'required_if:role,researcher|integer|min:1|exists:departments,id',
        ];
    }
}
