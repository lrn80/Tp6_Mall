<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\api\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username' => 'require',
        'phone_number' => 'require',
    ];

    protected $message = [
        'username' => '用户名必须',
        'phone_number' => '你忘记填写手机号了哦~',
    ];

    protected $scene = [
        'send_code' => ['phone_number'],
    ];
}