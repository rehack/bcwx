<?php
namespace app\wx_bargain_api\model;
use think\Model;

class UsersInfo extends Model{
    protected $autoWriteTimestamp = true;

    public static function getUserByOpenId($openid){
        $user = self::where('openid','=' , $openid)->find();
        return $user;
    }
}