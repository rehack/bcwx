<?php
namespace app\lib\exception;

class UserException extends BaseException{
    public $code=404;
    public $msg='查询的客户不存在！';
    public $errorCode=60000;
}
