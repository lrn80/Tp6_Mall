<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\common\lib\sms;


interface SmsBase
{
    public static function sendCode($phone, $code);
}