<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\common\lib;


class Num
{
    public static function getCode($len)
    {
        $code = rand(1000, 9999);
        if ($len == 6) {
            $code = rand(100000, 999999);
        }

        return $code;
    }
}