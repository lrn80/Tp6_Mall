<?php
/**
 * User: ruoning
 * Date: 2020/8/4
 * motto: 知行合一!
 */

namespace app\common\model\mysql;


class Category extends BaseModel
{

    /**
     * @param string $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalCategorys($field = "*") {
        $where = [
            "status" => config("status.mysql.table_normal"),
        ];

        $order = [
            "listorder" => "desc",
            "id" => "desc"
        ];

        $result = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();

        return $result;
    }

    public function getLists($where, $num = 10) {

        $order = [
            "listorder" => "desc",
            "id" => "desc"
        ];

        $result = $this->where("status", "<>", config("status.mysql.table_delete"))
            ->where($where)
            ->order($order)
            ->paginate($num);

        return $result;
    }

    /**
     * getChildCountInPids
     * @param $condition
     * @return mixed
     */
    public function getChildCountInPids($condition) {
        $where[] = ["pid", "in", $condition['pid']];
        $where[] = ["status", "<>", config("status.mysql.table_delete")];
        $res = $this->where($where)
            ->field(["pid", "count(*) as count"])
            ->group("pid")
            ->select();
        return $res;
    }

    /**
     * getNormalByPid
     * 根据pid获取正常的分类数据
     * @param integer $pid
     * @param [type] $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalByPid($pid = 0, $field) {
        $where = [
            "pid" => $pid,
            "status" => config("status.mysql.table_normal"),
        ];
        $order = [
            "listorder" => "desc",
            "id" => "desc"
        ];

        return $this->where($where)
                ->field($field)
                ->order($order)
                ->select();
    }
}