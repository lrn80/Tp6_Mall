<?php
/**
 * User: ruoning
 * Date: 2020/8/7
 * motto: 知行合一!
 */


namespace app\admin\validate;



class Image extends BaseValidate
{
    protected $rule = [
        'image_name' => 'checkImageSuffix'
    ];

    protected $message = [
        'image_name.checkImageSuffix' => '图片的后缀名错误'
    ];

    protected function checkImageSuffix($value, $rule, $data = [])
    {
        $arr = ['png' ,'gif', 'jpg'];
        if (! in_array(substr($value, strrpos($value, '.') + 1), $arr)) {
            return false;
        } else {
            return true;
        }
    }
}