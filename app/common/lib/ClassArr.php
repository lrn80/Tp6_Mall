<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\common\lib;


class ClassArr
{
    public static function smsClassStat()
    {
        return [
            'ali' => 'app\common\lib\sms\AliSms',
        ];
    }
    public static function initClass($type, $class, $params = [], $needInstance = false)
    {
        if (!array_key_exists($type, $class)) {
            return false;
        }

        $className = $class[$type];

        // new ReflectionClass
        return $needInstance == true ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
    }
}