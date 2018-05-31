<?php
namespace app\admin\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        ['login_name','require|max:20','登录名称不能为空|登录名称不能超过20个字符'],
        ['login_pwd','require','登录密码不能为空'],
        ['salt','require','密码加盐不可少'],
        ['admin_status','in:0,1','用户状态不能为空'],
        ['admin_phone',['regex'=>'/^1[3|4|5|7|8][0-9]\d{4,8}$/'],'请填写正确的手机号']
    ];
    protected $scene = [
        'NameLogin' => ['login_name', 'login_pwd'],
        'PhoneLogin' => ['admin_phone', 'login_pwd'],
    ];
}