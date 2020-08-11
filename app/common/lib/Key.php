<?php
/**
 * User: ruoning
 * Date: 2020/8/11
 * motto: 知行合一!
 */


namespace app\common\lib;


class Key
{
    /**
     * @param $userId
     * @return string
     */
    public static function UserCart($userId) {
        return config("redis.cart_pre") . $userId;
    }
}