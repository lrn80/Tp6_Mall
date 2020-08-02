<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\admin\business;
use \app\common\model\mysql\AdminUser as AdminUserModel;
use think\Exception;

class AdminUser
{
    public static function login($data)
    {
        try {

            $adminUser = self::getAdminUserByUsername($data['username']);

            if (! $adminUser) {
                throw new Exception("不存在该用户");
            }

            // 密码判断
            if (md5($data['password']) != $adminUser['password']) {
                throw new Exception("密码不正确");
                //return  show(config('status.error'), "密码不正确");
            }

            if ($adminUser['status'] != config('status.mysql.table_normal')) {
                throw new Exception("用户状态不正常");
                //return  show(config('status.error'), "用户状态不正常");
            }


        } catch (\Exception $e) {
            return show(config('status.error'), "内部异常，登陆失败");
        }

        session(config('admin.session_admin'), $adminUser);
        halt( session(config('admin.session_admin')));
        return true;
    }

    /**
     * 通过用户名获取用户的数据
     * @param $username
     * @return array
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getAdminUserByUsername($username)
    {
        $adminUserObj = new AdminUserModel();
        $adminUser = $adminUserObj->getAdminUserByUsername($username);

        if (empty($adminUser)) {
            return false;
        }

        return $adminUser->toArray();
    }

    public static function updateById($id)
    {
        $adminUserObj = new AdminUserModel();
        $updateData = [
            'last_login_time' => time(),
            'last_login_ip' => request()->ip(),
        ];

        return $adminUserObj->updateById($id, $updateData);
    }
}