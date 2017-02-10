<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class LoginController extends Controller
{
    public function login(Request $request){
    	if($request->isMethod('POST')){
    		if (Auth::guard('admin')->attempt(['name'=>$request->input('name'),'password'=>$request->input('password')], $request->has('remember'))) {
	            // Nav::menu(Auth::guard('admin')->id());
	            return response()->json(['error'=>0,'redirect_url'=>'/']);
	        } else {
	            return response()->json(['error'=>1,'msg'=>'帐号或密码错误']);
	        }
    	}

    	return view('admin.login.login');
    }

    public function logout(){
    	Auth::guard('admin')->logout();

    	return redirect()->to('login');
    }
}
