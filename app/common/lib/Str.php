<?php
/**
 * User: ruoning
 * Date: 2020/8/3
 * motto: 知行合一!
 */


namespace app\common\lib;


class Str
{
    /**
     * 生成前端的Token
     * @param $string
     * @return string
     */
    public static function getLoginToken($string)
    {
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = 'dawdw22434asdafer3ra';
        return sha1(md5($timestamp . $tokenSalt . $string));
    }
}