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
    'captcha' => 'require',
    'image_name' => 'checkImageSuffix'
];

    protected $message = [
        'username' => '用户必须填写',
        'password' => '密码必须填写',
        'captcha' => '验证必须填写',
        'image_name.checkImageSuffix' => '图片的后缀名错误'
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