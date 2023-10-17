<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');

        return [
            'name' => 'required|string|max:255',
            'nip' => [
                'required',
                'regex:/^[0-9]{4}$/', // 4 digit
                Rule::unique('users')->ignore($user->id),
            ],
            'dept_id' => 'required|integer',
            'role_id' => 'required|integer',
            'permission' => 'array',
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id),
            ],
            'role_id' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'nip' => 'NIP',
            'dept_id' => 'Department',
            'role_id' => 'Role',
            'permission' => 'Permission',
            'email' => 'Email',
        ];
    }
}
