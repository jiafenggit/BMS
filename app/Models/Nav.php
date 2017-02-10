<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $fillable = ['name','slug','url','pid','is_new','is_show','is_blank','icon','rank','is_content','content','type','slide'];
	public $timestamps=false;


    public static $rules = [
        'name' => 'required|max:30',
    ];

    public static $messages=[
        'name.required'=>'菜单名称不能为空'
    ];

	// 递归处理栏目
    public static function recursion($nav,$html='├──',$pid=0,$level=0){
    	$data=[];
    	foreach($nav as $k=>$v){
    		if($v['pid']==$pid){
    			$v['html']=str_repeat($html, $level);
                $v['level']=$level+1;
    			$data[]=$v;
    			unset($nav[$k]);
    			$data=array_merge($data,self::recursion($nav,$html,$v['id'],$level+1));
    		}
    	}
    	return $data;
    }

    // 递归处理栏目 子栏目放入child
    public static function recursion_children($nav,$id=0){
        $data=array();
        foreach($nav as $k=>$v){
            if($v['pid']==$id){
                $v['child']=self::recursion_children($nav,$v['id']);
                $data[]=$v;
            }
        }
        return $data;
    }

    //获得递归处理后的栏目
    public static function get_recursion_navs($where='1',$sort="asc",$child=0){
        $navs=Nav::orderBy('type','ASC')->orderBy('rank',$sort)->whereRaw($where)->get()->toArray();
        if($navs){
            $navs = $child==0 ? self::recursion($navs) : self::recursion_children($navs);
        }
        return $navs;
    }
}
