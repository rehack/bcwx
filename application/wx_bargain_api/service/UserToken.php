<?php
namespace app\wx_bargain_api\service;

use app\lib\exception\WechatException;
use app\wx_bargain_api\model\UsersInfo as UsersInfoModel;
use think\Exception;
use app\lib\enum\ScopeEnum;

class UserToken extends BaseToken{
    private $code;
    private $appid;
    private $app_secret;
    private $url;

    function __construct($code){
        // 初始化参数
        $this->code = $code;
        $this->appid = config('wechat.app_id');
        $this->app_secret = config('wechat.app_secret');
        // 获取openid和access_token接口地址
        $this->url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";

        $this->url = sprintf($this->url,$this->appid,$this->app_secret,$this->code);

       
    }
    

    // 调用微信接口 通过code获取access_token和openid
    private function getOpenId(){
        $wxResult = http_curl($this->url,'get','array');
        return $wxResult;
    }

    // 返回token令牌
    public function returnToken(){
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
                // 生成并返回令牌
                $token = $this->grantToken($wxResult);
                return $token;
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
        $access_token = $wxResult['access_token'];

        $user = UsersInfoModel::getUserByOpenId($openid);
        if($user){
            $uid = $user->id;
        }else{
            $userDetail = $this->getUserDetail($openid,$access_token);
            $uid = $this->addUser($userDetail);
        }
        // 准备
        $cachedValue = $this->prepareCachedData($wxResult,$uid);
        // 生成令牌，写入缓存
        $token = $this->saveToCache($cachedValue);
        return $token;

    }

    // 数据库新增用户
    private function addUser($data){
        $user = UsersInfoModel::create($data);
        return $user->id;
    }

    // 准备缓存数据
    private function prepareCachedData($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;//普通客户权限
        return $cachedValue;
    }

    // 写入缓存
    private function saveToCache($cachedValue){
        // 生成一个token
        $token = self::generateToken();
        // return $token;exit;
        $key = $token;
        $value = json_encode($cachedValue);
        $cache_expire_in = config('setting.cache_expire_in');//缓存过期时间

        // 写入文件缓存
        $result = cache($key,$value,$cache_expire_in);

        // 缓存失败
        if(!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }

        return $token;
    }


    // 通过access_token和openid获取用户详细信息
    private function getUserDetail($openid,$access_token){
        // 根据access_token和openid获取用户详细信息
        $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";

        $detail = http_curl($url,'get','array');
        // 对接口调用结果进行判断
        if(empty($detail)){
            throw new Exception('获取userDetail异常，微信内部错误');
        }else{
            // 微信返回错误码
            if(array_key_exists('errcode',$detail)){
                throw new WechatException([
                    "msg" => $detail['errmsg'],
                    "errorCode" => $detail['errcode']
                ]);
            }else{
                
                return $detail;
            }
        }
    }
}