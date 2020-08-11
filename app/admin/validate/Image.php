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
        'image_name' => 'checkImageSuffix',
        'size' => 'checkImageSize'
    ];

    protected $message = [
        'image_name.checkImageSuffix' => '图片的后缀名错误',
        'size.checkImageSize' => '图片的大小不能大于64kb'
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

    protected function checkImageSize($value, $rule, $data = []) {
        if ($value / 1024 > 64) {
            return false;
        } else {
            return true;
        }
    }
}