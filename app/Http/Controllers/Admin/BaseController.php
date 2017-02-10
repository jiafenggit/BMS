<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth,Cache;
use App\Models\Admin;

class BaseController extends Controller
{
    //
    protected $admin;

    public function __construct(Request $request){
        $this->admin=Auth::guard('admin')->user();

        view()->share('administrator',$this->admin);
    }

    // 更新所有管理员权限
    protected function updatePermission($admin_id=null){

        if($admin_id){
            Cache::forget('menus'.$admin_id);
            return true;
        }

        foreach(Admin::get() as $v){
            Cache::forget('menus'.$v->id);
        }
    }
}
