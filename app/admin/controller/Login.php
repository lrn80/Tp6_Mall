<?php
/**
 * User: ruoning
 * Date: 2020/7/31
 * motto: 知行合一!
 */


namespace app\admin\controller;

use app\admin\business\AdminUser;
use think\facade\View;
use \app\admin\validate\AdminUser as AdminUserValidate;
class Login extends AdminBase
{
    public function initialize()
    {
        if ($this->isLogin()) {
            return $this->redirect(url("index/index"));
        }
    }

    public function index()
    {
       return View::fetch("index");
    }

    public function md5()
    {
        echo md5('123456');
    }

    /**
     * 后端登录验证
     * @return \think\response\Json
     */
    public function check()
    {
        if (!$this->request->isPost()) {
            return show(config('status.error'), "请求方式不正确");
        }

        $username = $this->request->param('username', '', 'trim');
        $password = $this->request->param('password', '', 'trim');
        $captcha = $this->request->param('captcha', '', 'trim');

        $data = [
            'username' => $username,
            'password' => $password,
            'captcha' => $captcha,
        ];
        $validate = new AdminUserValidate();

        if (! $validate->check($data)) {
            return show(config('status.error'), $validate->getError());
        }

        if (!captcha_check($captcha)) {
            return show(config('status.error'), "验证码不正确");
        }

        try {
            $res = AdminUser::login($data);
        } catch (\Exception $e) {
             return show(config('status.error'), $e->getMessage());
        }

        if ($res) {
           return show(config('status.success'), '登陆成功');
        } else {
           return show(config('status.error'), '登陆失败');
        }
    }
}