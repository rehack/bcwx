<?php
namespace app\wx_bargain_api\service;

use app\lib\WechatException;
use app\wx_bargain_api\model\UsersInfo as UsersInfoModel;

class UserToken{
    private $code;
    private $appid;
    private $app_secret;
    private $url;

    function __cosntructor($code){
        // 初始化参数
        $this->code = $code;
        $this->appid = config('wechat.app_id');
        $this->app_secret = config('wechat.app_secret');
        // 获取openid和access_token接口地址
        $this->url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$app_secret}&code={$code}&grant_type=authorization_code";
    }
    

    // 调用微信接口 通过code获取access_token和openid
    private function getOpenId(){
        $wxResult = http_curl($this->url);
        return $wxResult;
    }

    // 生成token令牌
    public function get(){
        $wxResult = $this->getOpenId();
        // 对接口调用结果进行判断
        if(empty($wxResult)){
            throw new Exception('获取access_token和openid异常，微信内部错误');
        }else{
            // 微信返回错误码
            if(array_key_exists('errcode',$wxResult)){
                throw new WechatException([
                    "msg" => $wxResult['errmsg'],
                    "errorCode" => $wxResult['errcode']
                ]);
            }else{
                // 通过access_token和openid生成token令牌
                $this->grantToken($wxResult);
            }
        }

    }

    private function grantToken($wxResult){
        // 拿到openid，到数据库去查询这个openid是否存在
        // 如果存在不做处理，如果不存在就入库users_info
        // 生成令牌
        // 准备缓存数据，写入缓存（缓存格式：key:token value:wxResult,uid,scope）
        // 返回令牌

        $openid = $wxResult['openid'];
        $user = UsersInfoModel::getUserByOpenId($openid);
        if($user){
            $uid = $user->id;
        }else{
            $uid = $this->addUser($wxResult);
        }

        $cachedValue = $this->prepareCacheData($wxResult,$uid);

    }

    // 数据库新增用户
    private function addUser($data){
        $user = UsersInfoModel::create($data);
        return $user->id;
    }

    // 准备缓存数据
    private function prepareCacheData($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;
        return $cachedValue;
    }

    // 写入缓存
    private function saveToCache($cachedValue){

    }
}