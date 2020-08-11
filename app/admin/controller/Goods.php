<?php
/**
 * User: ruoning
 * Date: 2020/8/6
 * motto: 知行合一!
 */


namespace app\admin\controller;

use \app\common\business\Goods as GoodsBus;

class Goods extends AdminBase
{
    public function index() {
        $data = [];
        $title = input("param.title", "", "trim");
        $time = input("param.time", "", "trim");
        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($time)) {
            $data['create_time'] = explode(" - ", $time);
        }
        $goods = (new GoodsBus())->getLists($data, 5);
        return view("", [
            "goods" => $goods
        ]);
    }

    public function add() {
        return view();
    }

    public function save() {
        // 判断是否为post请求
        if(!$this->request->isPost()) {
            return show(config('status.error'), "参数不合法");
        }
        // todo：验证参数
        $data = input("param.");

        //防止csrf攻击做一次校验
        $check = $this->request->checkToken('__token__');
        if(!$check) {
            return show(config('status.error'), "非法请求");
        }
        // 数据处理 = > 基于验证成功之后
        $data['category_path_id'] = $data['category_id'];
        $result = explode(",", $data['category_path_id']);
        $data['category_id'] = end($result);
        $res = (new GoodsBus())->insertData($data);
        if(!$res) {
            return show(config('status.error'), "商品新增失败");
        }

        return show(config('status.success'), "商品新增成功");
    }
}