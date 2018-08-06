<?php
namespace app\wx_bargain_api\controller;

use app\wx_bargain_api\model\Goods as GoodsModel;
use app\wx_bargain_api\validate\Bargain as BargainValidate;
use app\wx_bargain_api\service\BaseToken;

class Bargain extends BaseController{
    
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only'=>'startBargain']
    ];

    // 发起砍价
    public function createBargain(){
        (new BargainValidate())->goCheck();

        $uid = BaseToken::getCurrentUid();

        $goods_id = input('get.goods_id');
        // 存入砍价表
        return $goods_id;
        
    }
}