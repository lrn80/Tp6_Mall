<?php
/**
 * User: ruoning
 * Date: 2020/7/31
 * motto: 知行合一!
 */


namespace app\admin\controller;


use app\BaseController;
use app\common\model\mysql\AdminUser;
use think\facade\View;

class Login extends AdminBase
{
    public function initialize()
    {
        if ($this->isLogin()) {
            return $this->redirect("index/index");
        }
    }

    public function index()
    {

       return View::fetch("index");
    }

    public function md5()
    {

    }

    public function check()
    {
        if (!$this->request->isPost()) {
            return show(config('status.error'), "请求方式不正确");
        }

        $username = $this->request->param('username', '', 'trim');
        $password = $this->request->param('password', '', 'trim');
        $captcha = $this->request->param('captcha', '', 'trim');

        if (empty($username) || empty($password) || empty($captcha)) {
            return show(config('status.error'), "参数不能为空！");
        }

        if (!captcha_check($captcha)) {
            return show(config('status.error'), "验证码不正确");
        }

        try {
            $adminUserObj = new AdminUser();
            $adminUser = $adminUserObj->getAdminUserByUsername($username);

            if (empty($adminUser) || $adminUser->status != config('status.mysql.table_normal')) {
                show(config('status.error'), "用户不存在");
            }

            $adminUser = $adminUser->toArray();

            // 密码判断

            $updateData = [
                'last_login_time' => time(),
                'last_login_ip' => request()->ip(),
            ];

            $res = $adminUserObj->updateById($adminUser['id'], $updateData);

            if (empty($res)) {
                return show(config('status.error'), "登陆失败");
            }
        } catch (\Exception $e) {
            return show(config('status.error'), "内部异常，登陆失败");
        }
        session(config('admin.session_admin', $adminUser));
        return show(config('status.success'), "登陆成功");
    }
}