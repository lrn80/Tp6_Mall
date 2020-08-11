<?php
/**
 * User: ruoning
 * Date: 2020/8/11
 * motto: 知行合一!
 */


namespace app\common\lib;


class Show
{
    public static function success($data = [], $message = "OK") {
        $result = [
            "status" => config("status.success"),
            "message" => $message,
            "result" => $data
        ];
        return json($result);
    }

    public static function error($message = "error", $status = 0, $data = []) {
        $result = [
            "status" => $status,
            "message" => $message,
            "result" => $data
        ];
        return json($result);
    }
}