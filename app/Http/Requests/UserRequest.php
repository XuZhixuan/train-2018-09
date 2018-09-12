<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required',
            'department_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '邮箱不能为空',
            'department_id.required' => '所属部门不能为空',
        ];
    }
}
