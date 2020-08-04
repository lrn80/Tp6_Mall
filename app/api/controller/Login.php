<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\api\controller;


use app\api\validate\User;

class Login extends ApiBase
{
    public function index()
    {
        if ($this->request->isPost()) {
            return show(config('status.error'), '请求方式不对');
        }

        $phone_number = $this->request->param('phone_number', '', 'trim');
        $code = $this->request->param('code', 0, 'intval');
        $type = $this->request->param('type', 0, 'intval');

        $data = [
            'phone_number' => $phone_number,
            'code' => $code,
            'type' => $type,
        ];

        $validate = new User();
        if (! $validate->scene('login')->check($data)) {
            return show(config('status.error'), $validate->getError());
        }

        try {
            $result = (new \app\common\bussiness\User())->login($data);
        } catch (\Exception $e) {
            return show($e->getCode(), $e->getMessage());
        }

        if ($result) {
          return  show(config('status.success'), '登陆成功', $result);
        }
        return show(config('status.error'), '登陆失败');
    }
}