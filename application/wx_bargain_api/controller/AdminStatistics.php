<?php
namespace app\wx_bargain_api\controller;

use app\wx_bargain_api\model\BargainOrder as BargainOrderModel;

// 后台数据统计
class AdminStatistics{
    

    public function getOrders(){
        // return GoodsModel::all();exit;
        $orders = BargainOrderModel::with('usersInfo,goods,helpers.user')->withSum('helpers','bargain_money')->select();
        return $orders;
    }
}