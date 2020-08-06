<?php
/**
 * User: ruoning
 * Date: 2020/8/4
 * motto: 知行合一!
 */


namespace app\common\business;

use \app\common\model\mysql\Goods as GoodsModel;
use think\facade\Cache;

class Goods
{
    public $model = NULL;

    public function __construct()
    {
        $this->model = new GoodsModel();
    }

    /**
     * 新增商品逻辑
     * @param $data
     * @return array|bool|int|mixed
     */
    public function insertData($data) {
        // 开启一个事务
        $this->model->startTrans();
        //$this->model->startTrans();
        try {
            $goodsId = $this->add($data);
            if (!$goodsId) {
                return $goodsId;
            }
            // 执行数据插入到 sku表中哦。
            // 如果是 统一规格
            if ($data['goods_specs_type'] == 1) {
                $goodsSkuData = [
                    "goods_id" => $goodsId,
                ];
                // untodo 小伙伴自行完成
                return true;
            } elseif ($data['goods_specs_type'] == 2) { // 多规格他是我们电商的核心
                $goodsSkuBisobj = new GoodsSkuBis();
                $data['goods_id'] = $goodsId;
                $res = $goodsSkuBisobj->saveAll($data);
                // 如果不为空
                if (!empty($res)) {
                    // 总库存
                    $stock = array_sum(array_column($res, "stock"));
                    $goodsUpdateData = [
                        "price" => $res[0]['price'],
                        "cost_price" => $res[0]['cost_price'],
                        "stock" => $stock,
                        "sku_id" => $res[0]['id'],
                    ];
                    // 执行完毕之后 更新 主表中的数据哦。
                    $goodsRes = $this->model->updateById($goodsId, $goodsUpdateData);
                    if (!$goodsRes) {
                        throw  new \think\Exception("insertData:goods主表更新失败");
                    }
                } else {
                    throw new \think\Exception("sku表新增失败");
                }
            }
            // 事务提交
            $this->model->commit();
            return true;
        }catch (\think\Exception $e) {
            // 记录日志 untodo
            // 事务回滚
            $this->model->rollback();
            return false;
        }
    }


    /**
     * 获取分页列表的数据哦
     * @param $data
     * @param int $num
     * @return array
     */
    public function getLists($data, $num = 5) {

        $likeKeys = [];// 如果没有定义这个 的时候会有报错
        if(!empty($data)) {
            $likeKeys = array_keys($data);
        }
        try {
            $list = $this->model->getLists($likeKeys, $data, $num);
            $result = $list->toArray();
        }catch (\Exception $e) {
            // 最好这个地方的结构可以写到基础类库中
            $result = \app\common\lib\Arr::getPaginateDefaultData($num);
        }
        return $result;
    }

    /**
     * 获取首页大图（轮播图）
     * @return [type] [description]
     */
    public function getRotationChart() {
        $data = [
            "is_index_recommend" => 1,
        ];
        $field = "sku_id as id, title, big_image as image";

        try {
            $result = $this->model->getNormalGoodsByCondition($data, $field, 5);
        }catch (\Exception $e) {
            return \app\common\lib\Arr::getPaginateDefaultData(5);
            return [];
        }
        return $result->toArray();
    }

    public function cagegoryGoodsRecommend($categoryIds) {
        if(!$categoryIds) {
            return [];
        }
        // 栏目的获取预留给大家的作业 71 51  in category   pid
        foreach ($categoryIds as $k => $categoryId) {
            $result[$k]["categorys"] = [];
        }
        foreach($categoryIds as $key => $categoryId) {
            $result[$key]["goods"] = $this->getNormalGoodsFindInSetCategoryId($categoryId);
        }
        return $result;
    }

    public function getNormalGoodsFindInSetCategoryId($categoryId) {
        $field = "sku_id as id, title, price , recommend_image as image";
        try {
            $result = $this->model->getNormalGoodsFindInSetCategoryId($categoryId, $field);
        }catch (\Exception $e) {
            return [];
        }
        return $result->toArray();
    }

    public function getNormalLists($data, $num = 5, $order) {
        try {
            $field = "sku_id as id, title, recommend_image as image,price";
            $list = $this->model->getNormalLists($data, $num, $field, $order);
            $res = $list->toArray();
            $result = [
                "total_page_num" => isset($res['last_page']) ? $res['last_page'] : 0,
                "count" => isset($res['total']) ? $res['total'] : 0,
                "page" => isset($res['current_page']) ? $res['current_page'] : 0,
                "page_size" => $num,
                "list" => isset($res['data']) ? $res['data'] : []
            ];
        }catch (\Exception $e) {
            ///echo $e->getMessage();exit;
            // 演示之前的地方
            $result = [];
        }
        return $result;
    }

    public function getGoodsDetailBySkuId($skuId) {
        // sku_id sku表 => goods_id goods表 => tilte image description
        // sku  => sku数据
        // join
        $skuBisObj = new GoodsSkuBis();
        $goodsSku = $skuBisObj->getNormalSkuAndGoods($skuId);

        if(!$goodsSku) {
            return [];
        }
        if(empty($goodsSku['goods'])) {
            return [];
        }
        $goods = $goodsSku['goods'];
        //商品ID
        $skus = $skuBisObj->getSkusByGoodsId($goods['id']);
        if(!$skus) {
            return [];
        }
        $flagValue = "";
        foreach($skus as $sv) {
            if($sv['id'] == $skuId) {
                $flagValue = $sv["specs_value_ids"];
            }
        }
        $gids = array_column($skus, "id", "specs_value_ids");

        if($goods['goods_specs_type'] == 1) {
            $sku = [];
        } else {
            $sku = (new SpecsValueBis())->dealGoodsSkus($gids, $flagValue);
        }
        $result = [
            "title" => $goods['title'],
            "price" => $goodsSku['price'],
            "cost_price" => $goodsSku['cost_price'],
            "sales_count" => 0,
            "stock" => $goodsSku['stock'],
            "gids" => $gids,
            "image" => $goods['carousel_image'],
            "sku" => $sku,
            "detail" => [
                "d1" => [
                    "商品编码" => $goodsSku['id'],
                    "上架时间" => $goods['create_time'],
                ],
                "d2" => preg_replace('/(<img.+?src=")(.*?)/', '$1'.request()->domain().'$2',$goods['description']),
            ],

        ];

        // 记录数据到redis 作为商品PV统计
        Cache::inc("mall_pv_".$goods['id']);
        return $result;
    }
}