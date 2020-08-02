<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\common\bussiness;


use app\common\lib\sms\AliSms;

class Sms
{
    public static function sendCode($phoneNumber)
    {
        // 生成短信验证码 4 位
        $code = rand(1000, 9999);

        $sms = AliSms::sendCode($phoneNumber, $code);

        // 将短信验证码记录到redis

        if ($sms) {

        }

        return true;
    }
}