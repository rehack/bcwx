<?php
namespace app\wx_bargain_api\controller;

use app\wx_bargain_api\model\Goods as GoodsModel;
use app\wx_bargain_api\validate\Bargain as BargainValidate;
use app\wx_bargain_api\service\BaseToken;
use app\wx_bargain_api\model\UsersInfo as UsersInfoModel;
use app\wx_bargain_api\model\BargainOrder as BargainOrderModel;
use app\wx_bargain_api\model\Helpers as HelpersModel;
use app\lib\exception\UserException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\BargainException;

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
        $deal_money = $currentGoods->original_price;

        
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

    // 通过bargain单号获取详细信息
    public function getDetail(){
        $bargainNo = input('get.no');
        // return $bargainNo;
        if($bargainNo){
            $bargainOrder = BargainOrderModel::with('goods')->where('bargain_sn',$bargainNo)->find();
            if($bargainOrder){
                return json($bargainOrder);
            }else{
                throw new BargainException();
            }
        }
    }

    // 好友帮助砍价
    public function doBargain(){
        $no = input('post.no');
        if(!$no){
            throw new BargainException([
                'msg'=>'砍价单参数不正确',
                'code' => 403,
                'errorCode' => 60004

            ]);
        }
        
        // 通过单号查询砍价单是否存在
        $bargainOrder = BargainOrderModel::where('bargain_sn',$no)->find();
        // return $bargainOrder;
        $bargainOrderId = $bargainOrder->id;//订单id号
        if(!$bargainOrder){
            throw new BargainException();
        }


        

        // 判断活动时间
        $settingTime = strtotime(config('setting.time'));

        $nowTime = time();

        if($nowTime>$settingTime){
            // 活动过期
            throw new BargainException([
                'msg' => '当前活动已经过期',
                'code' => 403,
                'errorCode' => 60004
            ]);
        }

        // 判断是否已经最低价
        // 当前的价格
        $nowPrice = $bargainOrder->deal_money;
        
        // 商品最低价
        $lowPrice = $bargainOrder->goods->activity_money;
        

        // 差价
        $cPrice = (float)$nowPrice - (float)$lowPrice;
        
        $randMoney = randomFloat(1,10,$cPrice);//随机砍价金额 小于差价
        if(!$randMoney){
            throw new BargainException([
                'msg' => '当前已经是该产品最低价了，别再砍了!',
                'code' => 403,
                'errorCode' => 60004
            ]);
        }
        // return $randMoney;
        
        // 判断当前用户是否已经帮助过砍价
        $helperId = BaseToken::getCurrentUid();

        $helper = UsersInfoModel::get($helperId);
        $helpBargain = $helper->helpers()->where('order_id',$bargainOrderId)->find();

        if($helpBargain){
            throw new BargainException([
                'msg' => '谢谢！您已经帮助TA砍过价了',
                'code' => 403,
                'errorCode' => 60003
            ]);
        }


        // 通过判断后存入bargain_helpers表
        $data = [
            'order_id' => $bargainOrderId,
            'bargain_money' => $randMoney
        ];
        $res = $helper->helpers()->save($data);
        if($res){
            return json([
                'msg'=>'ok',
                'money' => $res->bargain_money
            ]);
        }


        // 对订单当前价格进行修改

    }
}