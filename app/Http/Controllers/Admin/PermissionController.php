<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Permission;
use Cache;

use App\Http\Requests\Admin\StorePermissionPostRequest,App\Http\Requests\Admin\UpdatePermissionPostRequest;

class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$this->admin->can('admin.permission')){
            abort(403);
        }
        $perms=Permission::get_recursion_permissions();
        // dd($perms);
        return view('admin.permission.index')->with(compact('perms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!$this->admin->can('perm.create')){
            abort(403);
        }
        $perms=Permission::get_recursion_permissions(2);
        // dd($perms);
        return view('admin.permission.create')->with(['perms'=>$perms]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionPostRequest $request)
    {
        if(!$this->admin->can('perm.create')){
            abort(403);
        }
        Permission::create($request->all());
        $this->flushPermisionCache();
        return redirect()->route('permission.index')->with(['success'=>1,'message'=>'添加权限成功']);
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
        if(!$this->admin->can('perm.edit')){
            abort(403);
        }
        $perm=Permission::findOrFail($id);
        $perms=Permission::get_recursion_permissions(2);
        return view('admin.permission.edit')->with(compact('perm','perms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionPostRequest $request, $id)
    {
        if(!$this->admin->can('perm.edit')){
            abort(403);
        }
        $perm=Permission::findOrFail($id);

        $perm->update($request->all());

        $this->flushPermisionCache();

        $this->updatePermission();

        return redirect()->back()->with(['success'=>1,'message'=>'更新权限成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$this->admin->can('perm.destroy')){
            return response()->json(['error'=>1,'msg'=>'对不起，你没有权限']);
        }
        if(\DB::table('permission_role')->where('permission_id',$id)->first()){
            // 权限正在被使用 
            return response()->json(['error'=>1,'msg'=>'权限正在被使用']);
        }

        if(\DB::table('permissions')->where('pid',$id)->first()){
            // 权限含有子类 
            return response()->json(['error'=>1,'msg'=>'权限含有子类,不能删除']);
        }
        Permission::where('id',$id)->delete();
        $this->flushPermisionCache();
        return response()->json(['error'=>0,'msg'=>'权限删除成功']);
    }

    //清除权限缓存
    protected function flushPermisionCache(){
        Cache::forget('permsision:recursion');
        Cache::forget('permsision:recursion_children');
    }
}
