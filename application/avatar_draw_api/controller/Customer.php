<?php
namespace app\avatar_draw_api\controller;
use app\avatar_draw_api\model\Customer as CustomerModel;
use app\avatar_draw_api\model\LuckyItem as LuckyItemModel;
use app\wx_public_api\service\UserToken;

class Customer extends BaseController{

    // 抽奖项目数据
    public function getLuckyItem(){
        return LuckyItemModel::order('lun')->select();
    }

    // 设置抽奖轮次
    public function setLun(){
        $lun = input('post.lun');
        $uid = UserToken::getCurrentVarByToken('uid');
        CustomerModel::where('id', $uid)
        ->update(['lun' => $lun]);
    }
    // 所有本轮参与抽奖人员
    public function getAllCustomer(){
        $lun = input('get.lun');
        $res = CustomerModel::where('isprize',0)->where('lun',$lun)->select();
        return $res;
    }

    // 更新中奖人员
    public function updateLucky(){
        $data = input('post.lucky');

        foreach ($data['win_prize'] as $key => $value) {
            CustomerModel::where('id',$value['id'])->update(['isprize' => 1,'prize_item' => $data['lucky_item_name']]);
        }
    }

    // 初始化数据，所有变成未中奖状态
    public function initData(){
        CustomerModel::where('1=1')->update(['isprize' => 0,'prize_item'=>NULL]);
    }

    // 查询自己是否中奖
    public function isPrize(){
        // 通过token从缓存从获取UID
        $uid = UserToken::getCurrentVarByToken('uid');
        $c = CustomerModel::get($uid);
        return json($c);
        
    }

}