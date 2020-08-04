<?php
/**
 * User: ruoning
 * Date: 2020/8/3
 * motto: 知行合一!
 */


namespace app\api\controller;
use  \app\common\bussiness\User as UserBus;

class User extends AuthBase
{
    public function index()
    {
        $user =  (new UserBus())->getNormalUserById($this->userId);

        $resultUser = [
            'id' => $user['id'],
            'username' => $user['username'],
            'sex' => $user['sex']
        ];

        return show(config('status.success'), 'OK', $resultUser);
    }

    public function update()
    {
        $username = $this->request->param('username', '', 'trim');
        $sex = $this->request->param('sex', 0, 'intval');

        $data = [
            'username' => $username,
            'sex' => $sex,
        ];

        $validate = (new \app\api\validate\User())->scene('update.user');
        if (! $validate->check($data)) {
            return show(config('status.error') . $validate->getError());
        }

        $userBusObj = new UserBus();
        try {
            $user = $userBusObj->update($this->userId, $data);
            //
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }


        if (!$user) {
            return show(config('status.error'), '用户信息修改失败');
        }

        return show(1, 'ok');
    }
}