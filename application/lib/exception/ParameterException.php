<?php
namespace app\lib\exception;

use think\Exception;

class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}