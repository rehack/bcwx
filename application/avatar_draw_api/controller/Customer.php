<?php
namespace app\avatar_draw_api\controller;

use app\avatar_draw_api\model\Customer as CustomerModel;

class Customer extends BaseController{
    public function getAllCustomer(){
        $res = CustomerModel::select();
        return $res;
    }
}