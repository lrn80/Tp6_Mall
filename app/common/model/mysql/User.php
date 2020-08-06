<?php
/**
 * User: ruoning
 * Date: 2020/7/31
 * motto: 知行合一!
 */


namespace app\common\model\mysql;


use think\Model;

class User extends BaseModel
{
    /**
     * 自动写入当前时间
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    /**
     * 根据用户名获取后端表的的数据
     * @param $phone_number
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByPhoneNumber($phone_number)
    {
        if (empty($phone_number)) {
            return false;
        }

        $where = [
            'phone_number' => trim($phone_number),
        ];

        return $this->where($where)->find();
    }

    /**
     * 根据用户id传递用户表的数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id, $data)
    {
        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data)) {
            return false;
        }

        $where = [
            'id' => $id
        ];

        return $this->where($where)->save($data);
    }

    public function getUserById($id)
    {
        $id = intval($id);
        if (!$id) {
            return false;
        }
        return $this->find($id);
    }

    public function getUserByUsername($username)
    {
      if (empty($username)) {
          return false;
      }

      $where = [
          'username' => trim($username),
      ];

      return $this->where($where)->find();
    }
}