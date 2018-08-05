<?php
namespace app\lib\exception;
// 用户权限异常
class ForbiddenException extends BaseException{
    public $code=403;
    public $msg='权限不够';
    public $errorCode=10001;
}
