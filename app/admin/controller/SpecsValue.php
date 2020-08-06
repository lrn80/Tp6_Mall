<?php
/**
 * User: ruoning
 * Date: 2020/8/6
 * motto: 知行合一!
 */


namespace app\admin\controller;

use app\common\business\SpecsValue as SpecsValueBus;
class SpecsValue extends AdminBase
{
    public function save() {
        $specsId = input("param.specs_id", 0, "intval");
        $name = input("param.name", "", "trim");
        $data = [
            "specs_id" => $specsId,
            "name" => $name,
        ];
        $id = (new SpecsValueBus())->add($data);
        if (!$id) {
            return show(config("status.error"), "新增失败");
        }
        return show(config("status.success"), "OK", ["id" => $id]);
    }

    public function getBySpecsId() {
        $specsId = input("param.specs_id", 0, "intval");
        if (!$specsId) {
            return show(config("status.success"), "没有数据哦");
        }
        $result = (new SpecsValueBus())->getBySpecsId($specsId);
        return show(config("status.success"), "OK", $result);
    }
}