<?php
/**
 * User: ruoning
 * Date: 2020/8/11
 * motto: 知行合一!
 */


namespace app\api\controller\mall;


use app\api\controller\ApiBase;
use app\common\business\Goods;
use app\common\lib\Show;

class Detail extends ApiBase
{
    public function index() {
        $id = input("param.id", 0, "intval");
        if (!$id) {
            //商品详情获取不到前端会直接跳转到首页
            return Show::error();
        }
        $result = (new Goods())->getGoodsDetailBySkuId($id);
        if (!$result) {
            return Show::error();
        }
        return Show::success($result);
    }
}