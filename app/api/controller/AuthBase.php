<?php
/**
 * User: ruoning
 * Date: 2020/8/3
 * motto: 知行合一!
 */


namespace app\api\controller;


class AuthBase extends  ApiBase
{
    public $accessToken = "";
    public $username;
    public $userId;
    public function initialize()
    {
        parent::initialize();
        $this->accessToken = $this->request->header('access-token');

        if ($this->accessToken || ! $this->isLogin()) {
            return $this->show(show(config('status.not_login'), '没有登陆'));
        }
    }

    public function isLogin()
    {
        $userInfo = cache(config('redis.token_pre') . $this->accessToken);

        if (!$userInfo) {
            return false;
        }

        if (!empty($userInfo['id']) && ! empty($userInfo['username'])) {
            $this->username = $userInfo['username'];
            $this->userId = $userInfo['id'];
            return true;
        }
    }
}