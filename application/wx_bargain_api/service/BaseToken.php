<?php
namespace app\wx_bargain_api\service;

class BaseToken{
    public static function generateToken(){
        // getRandChar()是common下公共函数
        $randChars = getRandChar(32);//32位随机字符串
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];//得到请求开始时的时间戳
        $salt = config('setting.salt');//加密盐
        // 将三个字符串md5加密得到token
        return md5($randChars.$timestamp.$salt);
    }
}