<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Role,App\Models\Permission;

use App\Http\Requests\Admin\StoreRolePostRequest,App\Http\Requests\Admin\UpdateRolePostRequest;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$this->admin->can('admin.role')){
            abort(403);
        }
        $roles=Role::orderBy('id','desc')->paginate(10);
        return view('admin.role.index')->with(compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->admin->can('role.create')){
            abort(403);
        }
        return view('admin.role.create')->with('perms',Permission::get_recursion_permissions(2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$this->admin->can('role.create')){
            abort(403);
        }
        $data=$request->all();

        $role=Role::create($data);

        $permissions=[];
        if(isset($data['permission']) && !empty($data['permission'])){
            foreach($data['permission'] as $v){
                $permissions[]=$v;
            }
        }

        $role->perms()->sync($permissions);

        return redirect()->route('role.index')->with(['success'=>1,'message'=>'添加角色成功']);
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
        if(!$this->admin->can('role.edit')){
            abort(403);
        }
        $role=Role::findOrFail($id);
        $perms=Permission::get_recursion_permissions(2);
        return view('admin.role.edit')->with(compact('role','perms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$this->admin->can('role.edit')){
            abort(403);
        }
        $role=Role::findOrFail($id);

        $data=$request->all();

        $role->update($data);

        $permissions=[];
        if(isset($data['permission']) && !empty($data['permission'])){
            foreach($data['permission'] as $v){
                $permissions[]=$v;
            }
        }

        $role->perms()->sync($permissions);

        $this->updatePermission();

        return redirect()->back()->with(['success'=>1,'message'=>'更新角色成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$this->admin->can('role.destroy')){
            return response()->json(['error'=>1,'msg'=>'对不起，你没有权限']);
        }
        if(\DB::table('role_user')->where('role_id',$id)->first()){
            // 该角色正在被使用 不能删除
            return response()->json(['error'=>1,'msg'=>'该角色正在被使用']);
        }
        $role=Role::findOrFail($id);
        $role->perms()->sync([]);
        $role->delete();
        return response()->json(['error'=>0,'msg'=>'角色删除成功']);
    }
}
