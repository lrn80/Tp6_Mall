<?php
/**
 * User: ruoning
 * Date: 2020/7/31
 * motto: 知行合一!
 */


namespace app\admin\controller;


class Logout extends AdminBase
{
    public function index()
    {
        session(config('admin.session_admin'), null);
        return redirect(url('login/index'));
    }
}