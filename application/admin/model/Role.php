<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class Role extends Model
{
    /**
     *查询父级角色
     *
     */
    public function getParentRole(){
        $res = Db::table('hc_role')->where(['parent_id'=>0,'status'=>1])->select();
        if($res){
            return $res;
        }else{
            return false;
        }
    }
    /**
     *
     */
    /**
     *查询所有的角色
     *
     */
    public function geAllRole(){
        $data = Db::table('hc_role')->select();
        $tree = $this->getRoleTree($data,0);
        return $tree;
    }
    /**
     *将所查询的角色通过递归变成无限极树状
     */
    public function getRoleTree($data,$pid=0){
        static $list = [];
        foreach ($data as $k=>$v){
            if($v['parent_id'] == $pid){
                $list[] = $v;
                unset($data[$k]);
                $this->getRoleTree($data,$v['id']);
            }
        }
        return $list;
    }

}