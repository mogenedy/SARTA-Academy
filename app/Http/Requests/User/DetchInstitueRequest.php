<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class DetchInstitueRequest extends FormRequest
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
        $user = $this->route()->parameter('user');

        if($user->hasRole('editor')){
            return [
                'institute_id' => 'required|integer|min:1|exists:institutes,id',
            ];
        }else if($user->hasRole('researcher')){
            return [
                'department_id' => 'required|integer|min:1|exists:departments,id',
            ];
        }

        return [];
    }
}
