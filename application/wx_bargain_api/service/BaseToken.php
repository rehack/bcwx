<?php
namespace app\wx_bargain_api\service;
use think\facade\Request;
use think\facade\Cache;
use app\lib\exception\TokenException;
use app\lib\exception\ForbiddenException;
use think\Exception;
use app\lib\enum\ScopeEnum;

class BaseToken{

    // 生成token
    public static function generateToken(){
        // getRandChar()是common下公共函数
        $randChars = getRandChar(32);//32位随机字符串
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];//得到请求开始时的时间戳
        $salt = config('setting.salt');//加密盐
        // 将三个字符串md5加密得到token
        return md5($randChars.$timestamp.$salt);
    }

    // 通过token从缓存中获取指定的值
    public static function getCurrentVarByToken($key){
        // 从客户的请求头信息里获取token
        $token = Request::header('Authorization');
        $values = Cache::get($token);

        // 如果缓存过期或不存在
        if(!$values){
            // 把异常抛到客户端，客户端重新获取token
            throw new TokenException();
        }else{
            if(!is_array($values)){
                $values = json_decode($values,true);
            }

            if(array_key_exists($key,$values)){
                return $values[$key];
            }else{
                throw new Exception('尝试获取的值并不存在');
            }
        }
    }

    // 从缓存中获取当前用户的uid
    public static function getCurrentUid(){
        $uid = self::getCurrentVarByToken('uid');
        return $uid;
    }

    // 客户和CMS管理员都能访问的接口权限 
    public function needPrimaryScope(){
        $scope = self::getCurrentVarByToken('scope');
        if($scope){
            if($scope >= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    // 只有用户才能访问的接口权限 前置方法
    public function needExclusiveScope(){
        $scope = self::getCurrentVarByToken('scope');

        if($scope){
            if($scope == ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
}