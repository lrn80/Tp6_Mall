<?php
/**
 * User: ruoning
 * Date: 2020/8/6
 * motto: 知行合一!
 */


namespace app\admin\controller;


class Specs extends AdminBase
{
    public function dialog() {
        return view("", [
            "specs" => json_encode(config("specs"))
        ]);
    }
}