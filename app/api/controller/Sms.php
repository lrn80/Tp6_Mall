<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\api\controller;


use app\api\validate\User;
use app\BaseController;
use \app\common\business\Sms as SmsBus;
class Sms extends BaseController
{
    public function code()
    {
       $phone_number = input('param.phone_number', '', 'trim');
       $data = [
           'phone_number' => $phone_number,
       ];

        try {
            validate(User::class)->scene('send_code')->check($data);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getError());
        }

        // 调用 business
        if (SmsBus::sendCode($phone_number, 4, 'ali')) {
            return show(config('status.success'), '发送验证码成功！');
        }

        return show(config('status.success'), 'ok');
    }
}