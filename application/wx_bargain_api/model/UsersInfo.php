<?php
namespace app\wx_bargain_api\model;
use think\Model;

class UsersInfo extends Model{
    protected $autoWriteTimestamp = true;

    protected $hidden = ['id','openid'];

    // 一个用户可以发起多个砍价
    public function bargainOrders(){
        
        return $this->hasMany('BargainOrder','uid');
    }


    // 一个用户可以参与帮助多个砍价，不同的砍价单
    public function helpers(){
        return $this->hasMany('Helpers','helper_id');
    }

    public static function getUserByOpenId($openid){
        $user = self::where('openid','=' , $openid)->find();
        return $user;
    }
}