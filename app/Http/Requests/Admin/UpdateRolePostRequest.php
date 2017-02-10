<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateRolePostRequest extends Request
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
            'display_name'=>'required',
        ];
    }

    public function messages(){
        return [
            'display_name.required'=>'角色中文名不能为空',
        ];
    }
}
