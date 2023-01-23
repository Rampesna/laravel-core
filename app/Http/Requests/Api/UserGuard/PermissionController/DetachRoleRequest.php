<?php

namespace App\Http\Requests\Api\UserGuard\PermissionController;

use Illuminate\Foundation\Http\FormRequest;

class DetachRoleRequest extends FormRequest
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
            'permission_id' => 'required|integer',
            'role_id' => 'required|integer',
        ];
    }
}
