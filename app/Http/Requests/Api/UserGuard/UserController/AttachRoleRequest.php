<?php

namespace App\Http\Requests\Api\UserGuard\UserController;

use Illuminate\Foundation\Http\FormRequest;

class AttachRoleRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'role_id' => 'required|integer',
        ];
    }
}
