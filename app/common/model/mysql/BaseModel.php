<?php
/**
 * User: ruoning
 * Date: 2020/8/4
 * motto: 知行合一!
 */


namespace app\common\model\mysql;


use think\Model;

class BaseModel extends Model
{
    /**
     * 自动写入时间 'auto_timestamp' => true,
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    public function updateById($id, $data) {
        $data['update_time'] = time();
        return $this->where(["id" => $id])->save($data);
    }

    public function getNormalInIds($ids) {
        return $this->whereIn("id", $ids)
            ->where("status", "=", config("status.mysql.table_normal"))
            ->select();
    }

    /**
     * 根据条件查询
     * @param array $condition
     * @param array $order
     * @return bool|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByCondition($condition = [], $order = ["id" => "desc"]) {
        if(!$condition || !is_array($condition)) {
            return false;
        }
        return $this->where($condition)
            ->order($order)
            ->select();
    }
}