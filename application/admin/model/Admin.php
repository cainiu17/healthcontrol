<?php
namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    /**
     *判断是否为手机号，且手机号是否正确
     * @param char phone 被检测的手机号
     * @return bool true/false
     */
    public function checkPhone($phone = ''){
        $reg = '/^1[3|4|5|7|8][0-9]\d{4,8}$/';
        if(preg_match($reg,$phone)){
            return true;
        }else{
            return false;
        }
    }
    /**
     *根据用户id获取用户名称
     * @param smallint uid 用户id
     * @return varchar uname 用户登录名称
     */
    public function getUserNameById($uid = ''){
        $user = $this->get($uid);
        return $user->getAttr('login_name');
    }
    /**
     *根据用户名获取登录的salt
     * @param varchar login_name 用户登录名称
     * @return char salt
     */
    public function getUserSaltByLname($login_name=''){
        $salt = $this->get(['login_name'=>$login_name]);
        return $salt->getAttr('salt');
    }
    /**
     *根据手机号获取登录的salt
     * @param varchar phone 用户手机号
     * @return char salt
     */
    public function getUserSaltByPhone($phone=''){
        $salt = $this->get(['admin_phone'=>$phone]);
        return $salt->getAttr('salt');
    }
    /**
     *
     * 根据用户名或者手机号判断此用户是否存在
     * @param varchar where 用户登录名称或手机号
     * @param varchar pwd   用户登录密码
     * @return bool true/false;
     */
    public function checkUserExist($where = ''){
        //判断条件是不是手机号
        $isPhone = $this->checkPhone($where);
        if($isPhone){
            $cUser = $this->get(['admin_phone' => $where]);
        }else{
            $cUser = $this->get(['login_name' => $where]);
        }
        if($cUser){
            return true;
        }else{
            return false;
        }
    }
    /**
     *根据用户id修改用户最后登录时间
     * @param samllint  uid  用户id
     * @return bool
     */
    public function updateLoginTime($uid){
        $user = $this->get($uid);
        $user->login_time = time();
        return $user->save();
    }
    /**
     *用户登录，验证密码是否正确
     * @param varchar login_method  登录方式
     * @param varchar pwd           登录密码
     * @return
     */
    public function checkUser($login_method='',$pwd){
        //判断用户是否存在
        $isExist = $this->checkUserExist($login_method);
        if($isExist){
            $isPhone = $this->checkPhone($login_method);
            if($isPhone){
                //获取登录密码的salt
                $salt = $this->getUserSaltByPhone($login_method);
                $cUser = $this->where(['admin_phone'=>$login_method,'login_pwd'=>md5($pwd.$salt)])->find();
            }else{
                //获取登录密码的salt
                $salt = $this->getUserSaltByLname($login_method);
                $cUser = $this->where(['login_name'=>$login_method,'login_pwd'=>md5($pwd.$salt)])->find();
            }
            if($cUser){
                $uid = $cUser->getAttr('id');
                //修改登录时间
                $this->updateLoginTime($uid);
                return $uid;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}