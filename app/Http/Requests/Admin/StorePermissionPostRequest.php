<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class StorePermissionPostRequest extends Request
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
            'name'=>'required|unique:permissions,name',
            'display_name'=>'required'
        ];
    }

    public function messages(){
        return [
            'name.required'=>'权限英文名不能为空',
            'name.unique'=>'权限英文名已经存在',
            'display_name.required'=>'权限中文名为空',
        ];
    }
}
