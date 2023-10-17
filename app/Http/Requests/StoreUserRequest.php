<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'nip' => 'required|regex:/^[0-9]{4}$/|unique:users',
            'dept_id' => 'required|integer',
            'role_id' => 'required|integer',
            'permission' => 'array',
            'email' => 'required|string|email|max:100|unique:users',
            'role_id' => 'required|integer',
            'password' => 'required|string|min:8|max:16',
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
            'password' => 'Password',
        ];
    }

}
