<?php
namespace app\lib\exception;

class WechatException extends BaseException{
    public $code=400;//http状态码
    public $msg='微信服务器接口调用失败';//错误具体信息
    public $errorCode=999;//自定义错误码
}
