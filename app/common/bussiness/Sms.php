<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\common\bussiness;


use app\common\lib\Num;
use app\common\lib\sms\AliSms;
use think\facade\Cache;

class Sms
{
    public static function sendCode($phoneNumber, int $len)
    {
        // 生成短信验证码 4 位
        $code = Num::getCode($len);

        $sms = AliSms::sendCode($phoneNumber, $code);

        // 将短信验证码记录到redis

        if ($sms) {
            Cache::set(config('redis.code_pre') . $phoneNumber, $code, config('redis.code_expire'));
        }



        return true;
    }
}