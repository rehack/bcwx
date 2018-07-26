<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return 'server running.';
    }

    // 接入微信公众平台开发
    public function access(){
        // 获取微信服务器传递的参数
        $signature=input('get.signature');
        $timestamp=input('get.timestamp');
        $nonce=input('get.nonce');
        $echostr=input('get.echostr');

        // 自定义一个token
        $token = 'rehack';

        // 将token、timestamp、nonce三个参数进行字典序排序
        $arr = [$token,$nonce,$timestamp];
        sort($arr);

        // 将三个参数字符串拼接成一个字符串进行sha1加密
        $str = sha1(implode($arr));

        // 开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
        if($str == $signature){
            echo $echostr;
        }
    }
}
