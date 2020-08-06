<?php
/**
 * User: ruoning
 * Date: 2020/8/4
 * motto: 知行合一!
 */


namespace app\api\controller;


class Index extends ApiBase
{
    public function getRotationChart() {
        $result = (new GoodsBis())->getRotationChart();
        return Show::success($result);
    }

    public function cagegoryGoodsRecommend() {
        $categoryIds = [
            71,
            51
        ];
        $result = (new GoodsBis())->cagegoryGoodsRecommend($categoryIds);
        return Show::success($result);
    }
}