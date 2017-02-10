<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Admin,App\Models\Role;

use App\Http\Requests\Admin\StoreAdminPostRequest,App\Http\Requests\Admin\UpdateAdminPostRequest;

class AdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$this->admin->can('admin.admins')){
            abort(403);
        }

    	$admins=Admin::orderBy('id','desc')->paginate(10);
        return view('admin.admin.index')->with(compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->admin->can('admin.create')){
            abort(403);
        }
        $roles=Role::get();
        return view('admin.admin.create')->with(compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminPostRequest $request)
    {

        if(!$this->admin->can('admin.create')){
            abort(403);
        }

    	$data=$request->all();

        $data['password']=\Hash::make($data['password']);

        $admin=Admin::create($data);

        if(isset($data['role'])){
            $roles=[];
            foreach($data['role'] as $v){
                $roles[]=$v;
            }
        }else{
            $roles=[];
        }

        $admin->roles()->sync($roles);

        return redirect()->route('admins.index')->with(['success'=>1,'message'=>'添加管理员成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if(!$this->admin->can('admin.edit')){
            abort(403);
        }

        $admin=Admin::findOrFail($id);
        $roles=Role::get();
        return view('admin.admin.edit')->with(compact('admin','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminPostRequest $request, $id)
    {

        if(!$this->admin->can('admin.edit')){
            abort(403);
        }

        $admin=Admin::findOrFail($id);
        $data=$request->all();

        if(isset($data['password']) && !empty($data['password'])){
            $data['password']=\Hash::make($data['password']);
        }else{
            unset($data['password']);
        }

        $admin->update($data);

        $roles=[];
        if(isset($data['role'])){
            $roles=[];
            foreach($data['role'] as $v){
                $roles[]=$v;
            }
        }

        $admin->roles()->sync($roles);

        $this->updatePermission($admin->id);

        return redirect()->back()->with(['success'=>1,'message'=>'更新管理员成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$this->admin->can('admin.destroy')){
            return response()->json(['error'=>1,'msg'=>'对不起，你没有权限']);
        }

        $admin=Admin::findOrFail($id);
        $admin->roles()->sync([]);
        $admin->delete();
        return response()->json(['error'=>0,'msg'=>'管理员删除成功']);
    }
}
