<?php
/**
 * User: ruoning
 * Date: 2020/8/4
 * motto: 知行合一!
 */


namespace app\admin\controller;

use think\facade\View;
use  \app\common\business\Category as CategoryBus;

class Category extends AdminBase
{
    public function index() {
        $pid = input("param.pid", 0, "intval");
        $data = [
            "pid" => $pid,
        ];
        try {
            $categorys = (new CategoryBus())->getLists($data, 5);
        }catch (\Exception $e) {
            $categorys = \app\common\lib\Arr::getPaginateDefaultData(5);;
        }

        //halt($categorys);
        return View::fetch("", [
            "categorys" => $categorys,
            "pid" => $pid,
        ]);
    }

    public function add() {
        try {
            $categorys = (new CategoryBus())->getNormalCategorys();
        }catch (\Exception $e ) {
            $categorys = [];
        }

        return View::fetch("", [
            "categorys" => json_encode($categorys),
        ]);
    }

    /**
     * 新增逻辑
     */
    public function save() {
        $pid = input("param.pid", 0, "intval");
        $name = input("param.name", "", "trim");

        // 参数校验
        $data = [
            'pid' => $pid,
            'name' => $name,
        ];
        $validate = new \app\admin\validate\Category();
        if(!$validate->check($data)) {
            return show(config('status.error'), $validate->getError());
        }

        try {
            $result = (new CategoryBus())->add($data);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }
        if($result) {
            return show(config("status.success"), "OK");
        }
        return show(config("status.error"), "新增分类失败");


    }

    /**
     * 排序
     * @return \think\response\Json
     */
    public function listorder() {
        $id = input("param.id", 0, "intval");
        $listorder = input("param.listorder", 0, "intval");
        // 预留专业: 请参考之前老师讲解的validate验证机制处理 相关验证
        if (!$id) {
            return show(config('status.error'), "参数错误");
        }

        try {
            $res = (new CategoryBus())->listorder($id, $listorder);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }
        if($res) {
            return show(config('status.success'), "排序成功");
        } else {
            return show(config('status.error'), "排序失败");
        }
    }

    /**
     * @return \think\response\Json
     */
    public function status() {
        $status = input("param.status", 0, "intval");
        $id = input("param.id", 0, "intval");
        // 预留专业: 请参考之前老师讲解的validate验证机制处理 相关验证  判断合法性  0  1 99
        if (!$id || !in_array($status, StatusLib::getTableStatus())) {
            return show(config('status.error'), "参数错误");
        }

        try {
            $res = (new CategoryBus())->status($id, $status);
        } catch (\Exception $e) {
            return show(config('status.error'), $e->getMessage());
        }
        if($res) {
            return show(config('status.success'), "状态更新成功");
        } else {
            return show(config('status.error'), "状态更新失败");
        }
    }

    /**
     * @return \think\response\View
     */
    public function dialog() {
        // 获取正常的一级分类数据。
        $categories = (new CategoryBus())->getNormalByPid();
        return view("", [
            "categories" => json_encode($categories),
        ]);
    }

    /**
     * @return \think\response\Json
     */
    public function getByPid() {
        $pid = input("param.pid", 0, "intval");
        $categories = (new CategoryBus())->getNormalByPid($pid);
        return show(config("status.success"), "OK", $categories);
    }
}