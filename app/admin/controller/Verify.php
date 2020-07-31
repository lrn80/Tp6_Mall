<?php
/**
 * User: ruoning
 * Date: 2020/7/31
 * motto: 知行合一!
 */


namespace app\admin\controller;


use think\captcha\facade\Captcha;

class Verify
{
    public function index()
    {
       return Captcha::create();
    }
}