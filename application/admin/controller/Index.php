<?php
namespace app\admin\controller;
use app\admin\model\Admin;
use think\Controller;
use think\captcha\Captcha;
use think\Cookie;
use think\Loader;
use think\Session;
use think\Validate;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch('index',['web_title'=>'首页']);
    }
    /**
     *验证验证码是否正确
     *
     */
    public function  checkCode($code){
        if($code == '') $code = $_GET['code'];
        $captcha = new Captcha(['reset'=>false]);
        if($captcha->check($code)){
            return json('1');
        }else{
            return json('0');
        }
    }
    /**
     *退出系统
     * 销毁session
     */
    public function outLogin(){
        if(Session::has('login_name')){
            Session::delete('login_name');
            $this->redirect('login');
        }else{
            Session::destroy();
            $this->redirect('login');
        }
    }
    /**
     *login登录信息验证
     */
    public function login(){
        //如果设置了session，直接跳到首页
        if(Session::has('login_name')){
            return $this->redirect('index');
        }
        if(empty($_POST)){
            return $this->fetch('login',['web_title'=>'登录']);
        }
        //验证验证码的非空及正确性
        $code = $_POST['code'];
        if($code =='' || !$this->checkCode($code)){
            return json(array('msg'=>'验证码输入不正确，请重新输入'));
        }
        //验证用户名密码是否为空，是否规范
        $validate = Loader::validate('Admin');
        //判断用户登录名是名称还是手机号
        if($_POST['condition'] == 'n'){
            $data = [
                'login_name' => $_POST['name'],
                'login_pwd' => $_POST['pwd'],
            ];
            $result = $validate->scene('NameLogin')->check($data);
        }else{
            $data = [
                'admin_phone' => $_POST['name'],
                'login_pwd' => $_POST['pwd'],
            ];
            $result = $validate->scene('PhoneLogin')->check($data);
        }
        if(!$result){
            return json(array('code'=>0,'msg'=>$validate->getError()));
        }else{
            //查询数据库是否有记录
            $admin = new Admin();
            $res = $admin->checkUser($_POST['name'],$_POST['pwd']);
            if($res){
                //是否有记住密码（7天）
//                if($_POST['remember']){
////                    $login_name = $admin->
//                    Cookie::set('YhxMJm',$_POST['name'],3600*24*7);
//                }
                $login_name = $admin->getUserNameById($res);
                Session::set('login_name',$login_name);
                return json(array('code'=>1));
            }else{
                return json(array('code'=>0,'msg'=>'用户名或密码不正确！'));
            }
        }
    }
}
