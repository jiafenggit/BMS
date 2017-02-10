<?php
/**
 * Created by PhpStorm.
 * User: yatou02
 * Date: 2017/2/9
 * Time: 17:59
 */
namespace App\Models;

use Zizaco\Entrust\EntrustPermission;
use Cache;

class Permission extends EntrustPermission
{
    protected $fillable=['name','display_name','description','type','icon','url','pid','rank','is_blank','is_show'];

    public static function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'name'  => 'required|unique:permissions,name' . ($id ? ",$id" : '')
            ],
            $merge);
    }

    public static function messages ($merge=[]) {
        return array_merge([
            'name.required'=>'名称不能为空',
            'name.unique'=>'权限名称已存在'
        ], $merge);
    }

    // 递归处理栏目
    public static function recursion($permissions,$html='├──',$pid=0,$level=0){


        $data=[];
        foreach($permissions as $k=>$v){
            if($v['pid']==$pid){
                $v['html']=str_repeat($html, $level);
                $v['level']=$level+1;
                $data[]=$v;
                unset($permissions[$k]);
                $data=array_merge($data,self::recursion($permissions,$html,$v['id'],$level+1));
            }
        }



        return $data;
    }

    // 递归处理栏目 子栏目放入child
    public static function recursion_children($arr,$id=0){

        $data=array();
        foreach($arr as $k=>$v){
            if($v['pid']==$id){
                $v['child']=self::recursion_children($arr,$v['id']);
                $data[]=$v;
            }
        }

        return $data;
    }

    //获得递归处理后的栏目
    public static function get_recursion_permissions($type=1){
        $permissions=Permission::orderBy('rank','asc')->get()->toArray();
        if($permissions){
            if($type==1){
                if($data=Cache::get('permsision:recursion_children','')) return $data;
                $permissions=self::recursion_children($permissions);
                Cache::forever('permsision:recursion_children',$permissions);
            }else{
                if($data=Cache::get('permsision:recursion','')) return $data;
                $permissions=self::recursion($permissions);
                Cache::forever('permsision:recursion',$permissions);
            }
        }

        return $permissions;
    }

    // 获取普通权限
    public static function get_common_permissions($type,$pagesize=30){
        $permissions=Permission::where('type',$type)->orderBy('rank','asc')->paginate($pagesize);
        return $permissions;
    }
}