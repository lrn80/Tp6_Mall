<?php
/**
 * User: ruoning
 * Date: 2020/8/7
 * motto: 知行合一!
 */


namespace app\admin\controller;


use \app\admin\validate\Image as ImageValidate;

class Image extends AdminBase
{
    public function upload() {

        if(!$this->request->isPost()) {
            return show(config("status.error"), "请求不合法");
        }

        $file = $this->request->file("file");

        // 1 、上传图片类型需要判断 png gif jpg  2、文件大小限制 600kb，
        $validate = new ImageValidate();

        if (! $validate->check(['image_name' => $file->getOriginalName()])) {
            return show(config('status.error'), $validate->getError());
        }

        //$filename = \think\facade\Filesystem::putFile('upload', $file);

        $filename = \think\facade\Filesystem::disk('public')->putFile("image", $file);

        if(!$filename) {
            return show(config("status.error"), "上传图片失败");
        }


        // 这个地方的路径一定要注意
        $imageUrl = [
            "image"  =>  "/storage/".$filename
        ];
        return show(config("status.success"), "图片上传成功", $imageUrl);

    }
    public function layUpload() {
        if(!$this->request->isPost()) {
            return show(config("status.error"), "请求不合法");
        }
        $file = $this->request->file("file");
        $filename = \think\facade\Filesystem::disk('public')->putFile("image", $file);
        if(!$filename) {
            return json(["code" => 1, "data" => []], 200);
        }

        $result = [
            "code" => 0,
            "data" => [
                "src" => "/upload/".$filename,
            ],
        ];
        return json($result, 200);
    }
}