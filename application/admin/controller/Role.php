<?php
namespace app\admin\controller;

use think\Controller;
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
            return $this->fetch('addRole',['web_title'=>'添加角色']);
        }else{
            $rbac = new rbac\Rbac();
        }
    }
}