<?php
/**
 * User: ruoning
 * Date: 2020/8/4
 * motto: 知行合一!
 */


namespace app\admin\validate;


use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'name'  =>  'require',
        'pid' =>  'require',
    ];

    protected $message = [
        'name'  =>  '分类名称必须',
        'pid' =>  '父类ID必须',
    ];
}