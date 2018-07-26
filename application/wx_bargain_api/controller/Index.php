<?php
namespace app\wx_bargain_api\controller;

use \think\Controller;

class Index extends Controller
{
    public function index()
    {
        return 'wxapi';
    }


    public function getBaseInfo(){
        // echo 1;exit;
        $appid = config('wechat.app_id');
        
        $redirect_uri=urlencode("http://127.0.0.1/wx_bargain_api/index/getUserOpenId");
        // echo $app_secret;

        // 获取code
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";//接口地址
        // echo $url;
        // header('location',$url);
        $this->redirect($url,302);
    }


    public function getUserOpenId(){
        // echo 1;exit;
        $appid = config('wechat.app_id');
        $app_secret = config('wechat.app_secret');
        $code = input('get.code');

        // echo $code;exit;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$app_secret."&code=".$code."&grant_type=authorization_code";
        // echo $url;exit;
        // 获取用户openid
        $res = $this->http_curl($url,'get','array');

        dump($res);
    }
    




    /**
     * $url 接口地址url
     * $type 请求类似get/post
     * $resType 最后返回的数据类型格式
     * $arr post请求传的参数
     */
    public function http_curl($url,$type='get',$resType='json',$arr=''){
        // 1.初始化curl
        $ch = curl_init();
        // 2.设置curl参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查



        if($type=='post'){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }

        // 3.采集
        $output = curl_exec($ch);
        // dump($url);
        // dump(curl_error($ch));exit;
        // dump($output);exit;
        // 4.关闭
        curl_close($ch);
        if($resType=='array'){
            // 默认返回的是一个object，加true返回的是一个数组
            return json_decode($output,true);
        }
        return $output;
    }
}
