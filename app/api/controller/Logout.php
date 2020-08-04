<?php
/**
 * User: ruoning
 * Date: 2020/8/3
 * motto: 知行合一!
 */


namespace app\api\controller;


class Logout extends  AuthBase
{
    public function index()
    {
        // 删除redis缓存
        $res = cache(config('redis.token_pre') . $this->accessToken, null);
        if ($res) {
            return show(config('status.error'), '退出登录成功');
        }
    }
}