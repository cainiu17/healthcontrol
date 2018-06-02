<?php
namespace app\admin\controller;

use think\Controller;
/**
 * 权限管理（User）
 *后台管理人员信息管理
 */
class User extends Controller
{
    /**
     *显示
     *
     *
     */
    public function index(){

    }
    /**
     * 添加管理员
     *
     */
    public function addUser(){
        if(!$_POST){
            return $this->fetch('addUser',['web_title'=>'添加管理员']);
        }
    }
}