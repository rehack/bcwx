<?php
namespace app\wx_bargain_api\controller;

use app\wx_bargain_api\model\Goods as GoodsModel;
use app\wx_bargain_api\validate\Bargain as BargainValidate;
use app\wx_bargain_api\service\BaseToken;
use app\wx_bargain_api\model\UsersInfo as UsersInfoModel;
use app\lib\exception\UserException;
use app\lib\exception\SuccessMessage;

class Bargain extends BaseController{
    
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only'=>'startBargain']
    ];

    // 发起砍价
    public function createBargain(){
        (new BargainValidate())->goCheck();

        $uid = BaseToken::getCurrentUid();

        $goods_id = input('post.goods_id');

        // 当前商品的活动价
        $currentGoods = GoodsModel::get($goods_id);
        $deal_money = $currentGoods->activity_money;

        
        // return $uid;
        $currentUser = UsersInfoModel::get($uid);
        if(!$currentUser){
            throw new UserException([
                'code' => 404,
                'msg' => '该用户不存在',
                'errorCode' => 60001
            ]);
        }

        // 判断当前的商品该用户是否已经发起过砍价 关联查询
        $userBargain = $currentUser->bargainOrders()->where('goods_id',$goods_id)->find();
        // return onlySn(config('setting.salt'));
        // return create_order_id();
        $data = [
            'goods_id' => $goods_id,
            'deal_money' => $deal_money,//最终交易价格 动态变化
            'bargain_sn' => create_order_id(),//唯一订单号
        ];
        if(!$userBargain){
            // 存入发起砍价表
            $bargainO = $currentUser->bargainOrders()->save($data);
            return json(['bargainSn'=>$bargainO->bargain_sn]);//返回砍价订单编号
        }else{
            return json(['bargainSn'=>$userBargain->bargain_sn]);//返回砍价订单编号
        }

        // return json(new SuccessMessage(),201);
    }
}