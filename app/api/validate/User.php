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
        'phone_number' => 'require|mobile',
        'code' => 'require|number|min:4',
        'type' => ['require', 'in' => '1, 2'],
        'sex' => ['require', 'in' => '0, 1, 2']
    ];

    protected $message = [
        'username' => '用户名必须',
        'phone_number.require' => '你忘记填写手机号了哦~',
        'phone_number.mobile' => '手机号格式不对',
        'code.require' => '验证码必须存在',
        'code.number' => '短信验证码必须为数字',
        'code.min' => '短信验证码不能低于4位',
        'type.require' => '类型必须',
        'type.in' => '类型数值错误',
        'sex.require' => '性别必须填写',
        'sex.in' => '性别数值错误',
    ];

    protected $scene = [
        'send_code' => ['phone_number'],
        'login' => ['phone_number', 'code', 'type'],
        'update_user' => ['username', 'sex'],
    ];
}