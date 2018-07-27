<?php
namespace app\lib\exception;

use think\exception\Handle;
use think\Log;
use think\facade\Request;

/**
 * Class ExceptionHandler
 * @package app\lib\exception
 */
class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    /**
     * @param \Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            //自定义异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            if (config("app_debug")) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }

        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    /**
     * @param \Exception $e
     */
    private function recordErrorLog(\Exception $e)
    {
        Log::init([
            'type' => 'File',
            'path' => ROOT_PATH. 'log' .DS,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(), 'error');//生产环境记录服务器内部错误
    }
}