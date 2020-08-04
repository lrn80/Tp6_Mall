<?php
/**
 * User: ruoning
 * Date: 2020/8/2
 * motto: 知行合一!
 */


namespace app\api\controller;


use app\BaseController;
use think\exception\HttpResponseException;

class ApiBase extends BaseController
{
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function show(...$args)
    {
        throw new HttpResponseException(show(...$args));
    }
}