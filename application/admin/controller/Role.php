<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Role as RoleModel;
use gmars\rbac;
/**
 *权限管理之角色管理
 *
 */
class Role extends Controller
{
    /**
     *角色管理展示
     */
    public function index(){

    }
    /**
     *添加角色
     *
     */
    public function addRole(){
        if(!$_POST){
            //查询角色为父级（parent_id 为空）的角色
            $role = new RoleModel();
            $data = $role->getParentRole();
//            print_r($data);
            return $this->fetch('addRole',['web_title'=>'添加角色','parentRole'=>$data]);
        }else{
            //添加角色
            $rbac = new rbac\Rbac();
            $data = [
                'name' => $_POST['name'],
                'status' => $_POST['status'],
                'description' => $_POST['description'],
                'sort_num' => $_POST['sort'],
                'parent_id' => $_POST['parentid']
            ];
            $res = $rbac->createRole($data);
            return $res;
        }
    }
}