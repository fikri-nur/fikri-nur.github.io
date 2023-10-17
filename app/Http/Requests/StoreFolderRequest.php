<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFolderRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|unique:folders|max:100',
            'folder_id' => 'nullable|exists:folders,id',
            'dept_id' => 'nullable|exists:departments,id',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
