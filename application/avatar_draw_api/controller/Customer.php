<?php
namespace app\avatar_draw_api\controller;

use app\avatar_draw_api\model\Customer as CustomerModel;

class Customer extends BaseController{
    public function getAllCustomer(){
        $res = CustomerModel::where('isprize',0)->select();
        return $res;
    }

    // 更新中奖人员
    public function updateLucky(){
        $data = input('post.lucky');
        foreach ($data as $key => $value) {
            CustomerModel::where('id',$value['id'])->update(['isprize' => 1]);
        }
    }
}