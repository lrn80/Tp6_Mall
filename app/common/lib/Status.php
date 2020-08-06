<?php
/**
 * User: ruoning
 * Date: 2020/8/4
 * motto: 知行合一!
 */


namespace app\common\lib;


class Status
{
    public static function getTableStatus() {
        $mysqlStatus = config("status.mysql");
        return array_values($mysqlStatus);
    }
}