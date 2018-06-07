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

}