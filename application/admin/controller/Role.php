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
        $this->assign('web_title','角色管理');
        $role = new RoleModel();
        $data = $role->geAllRole();
        $this->assign('data',$data);
        return $this->fetch();
    }
    /**
     *添加角色
     *
     */
    public function addRole(){
        if(!$_POST){
            //查询角色为父级（parent_id 为空）的角色
            $role = new RoleModel();
            $data = $role->geAllRole();
            if($data){
                $this->assign('parentRole',$data);
            }
            $this->assign('web_title','添加角色');
            return $this->fetch();
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
    /**
     *获取所有角色
     *
     */
    public function getAllRole(){

    }
}