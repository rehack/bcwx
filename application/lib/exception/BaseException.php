<?php
namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    public $code = 400; //HTTP 状态码
    public $msg = '参数错误'; //具体信息
    public $errorCode = 10000; //自定义错误码

    /**设置错误参数
     * @param array $params
     */
    public function __construct($params = []){

        if(!is_array($params)){
            return ;
//            throw new Exception('参数错误!!!');
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}