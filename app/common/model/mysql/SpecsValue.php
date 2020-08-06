<?php
/**
 * User: ruoning
 * Date: 2020/8/6
 * motto: 知行合一!
 */


namespace app\common\model\mysql;


class SpecsValue extends BaseModel
{
    public function getNormalBySpecsId($specsId, $field="*") {
        $where = [
            "specs_id" => $specsId,
            "status" => config("status.mysql.table_normal"),
        ];

        return $this->where($where)
            ->field($field)
            ->select();
    }
}