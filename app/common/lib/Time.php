<?php
/**
 * User: ruoning
 * Date: 2020/8/3
 * motto: 知行合一!
 */


namespace app\common\lib;


class Time
{
    public static function userLoginExpiresTime($type = 2)
    {
        if ($type == 1) {
            $day = 1 * 7;
        } else {
            $day = 2 * 30;
        }

        return $day * 24 * 3600;
    }
}