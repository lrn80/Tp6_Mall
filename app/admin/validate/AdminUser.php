<?php
/**
 * User: ruoning
 * Date: 2020/7/31
 * motto: 知行合一!
 */


namespace app\admin\validate;


use think\Validate;

class AdminUser extends  Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha' => 'require'
    ];

    protected $message = [
        'username' => '用户必须填写',
        'password' => '密码必须填写',
        'captcha' => '验证必须填写',
    ];

    protected function  checkCaptcha($value, $rule, $data = [])
    {
        if (!captcha_check($value)) {
            return '验证码不正确';
        } else {
            return true;
        }
    }
}