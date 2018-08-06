<?php
namespace app\wx_bargain_api\model;
use think\Model;

class UsersInfo extends Model{
    protected $autoWriteTimestamp = true;

    // 一个用户可以发起多个砍价
    public function bargainOrders(){
        return $this->hasMany('BargainOrder','uid');
    }


    public static function getUserByOpenId($openid){
        $user = self::where('openid','=' , $openid)->find();
        return $user;
    }
}