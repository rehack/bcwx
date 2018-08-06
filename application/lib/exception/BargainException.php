<?php
namespace app\lib\exception;

class BargainException extends BaseException{
    public $code=404;
    public $msg='不存在该砍价单';
    public $errorCode=60002;
}
