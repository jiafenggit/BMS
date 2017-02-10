<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class StoreAdminPostRequest extends Request
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
            'name'=>'required|unique:admins,name',
            'password'=>'required|confirmed'
        ];
    }

    public function messages(){
        return [
            'name.required'=>'用户名不能为空',
            'name.unique'=>'用户名已经存在',
            'password.required'=>'密码不能为空',
            'password.confirmed'=>'密码不一致'
        ];
    }
}
