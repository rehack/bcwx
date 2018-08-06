<?php
namespace app\wx_bargain_api\controller;

use app\wx_bargain_api\model\Goods as GoodsModel;

class Goods{
    

    public function getGoods(){
        // return GoodsModel::all();exit;
        $goods = GoodsModel::with('images')->all();
        return $goods;
    }
}