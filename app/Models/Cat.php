<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $fillable = ['name','brief','pid','keywords','description','img_url','rank','is_show','filter_attr'];

    protected $table='p_cats';

	public $timestamps=false;


    public static $rules = [
        'name' => 'required|max:30',
    ];

    public static $messages=[
        'name.required'=>'栏目名称不能为空'
    ];

	// 递归处理栏目
    public static function recursion($cat,$html='├──',$pid=0,$level=0){
    	$data=[];
    	foreach($cat as $k=>$v){
    		if($v['pid']==$pid){
    			$v['html']=str_repeat($html, $level);
                $v['level']=$level+1;
    			$data[]=$v;
    			unset($cat[$k]);
    			$data=array_merge($data,self::recursion($cat,$html,$v['id'],$level+1));
    		}
    	}
    	return $data;
    }

    // 递归处理栏目 子栏目放入child
    public static function recursion_children($cat,$id=0){
        $data=array();
        foreach($cat as $k=>$v){
            if($v['pid']==$id){
                $v['child']=self::recursion_children($cat,$v['id']);
                $data[]=$v;
            }
        }
        return $data;
    }

    //获得递归处理后的栏目
    public static function get_recursion_cats($where='1',$child=0){
        $catgories=Cat::orderBy('rank','asc')->whereRaw($where)->get()->toArray();
        if($catgories){
            $catgories=$child==0?self::recursion($catgories):self::recursion_children($catgories);
        }

            
        return $catgories;
    }

    public static function get_childs($pid=0){
        $cat=self::orderBy('rank','asc')->get()->toArray();

        $tree=array();
        
        foreach($cat as $k=>$v){
            if($v['pid']==$pid){
                $tree[]=$v['id'];
                unset($cat[$k]);
                self::get_childs($cat,$v['id']);
            }
        }
        $tree[]=$pid;
        return $tree;
    }


    public function subcats(){
        return $this->hasMany('App\Cat','pid','id');
    }
}
