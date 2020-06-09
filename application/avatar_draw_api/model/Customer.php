<?php
namespace app\avatar_draw_api\model;
use think\Model;

class Customer extends Model{
    protected $autoWriteTimestamp = true;

    protected $hidden = ['openid'];


    public static function getUserByOpenId($openid){
        $user = self::where('openid','=' , $openid)->find();
        return $user;
    }
}