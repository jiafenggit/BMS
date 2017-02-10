<?php

namespace App\Tools;
//工具：导航菜单类 lizhigang
use App\Models\Cat;
use App\Models\Nav as Navs;
class Nav{
	public static function menu($id){
        // 菜单处理
        $menus=\Cache::rememberForever('menus'.$id, function() use ($id) {
            $role=\DB::table('role_user')->where('user_id',$id)->lists('role_id');
            $menus=\DB::table('permission_role')->whereIn('role_id',$role)->join('permissions','permission_role.permission_id','=','permissions.id')->distinct()->where('is_show',1)->orderBy('rank','asc')->get();

            foreach($menus as $k=>$v){
                $menus[$k]=(array)$v;
            }

            return $menus=\App\Models\Permission::recursion_children($menus);
        });

        return $menus;
    }

    public static function cat(){
        $cats=\Cache::rememberForever('home_pcat', function() {
            return Cat::get_recursion_cats('is_show=1',1);
        });

        return $cats;
    }
    
    public static function nav($position='header'){
        //头部导航
        if($position=='header'){
            $navs=\Cache::rememberForever('home_nav_header', function() {
                return Navs::get_recursion_navs('type=1 AND is_show=1','asc',1);
            });

            return $navs;
        }

        //尾部导航
        $navs=\Cache::rememberForever('home_nav_footer', function() {
            return Navs::get_recursion_navs('type=2 AND is_show=1','asc',1);
        });

        return $navs;
    }
}