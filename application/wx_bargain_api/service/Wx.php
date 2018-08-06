<?php
namespace app\wx_bargain_api\service;
use think\Exception;

class Wx{

    // 获取微信全局access_token
    public function getAccessToken(){
        $at = cache('access_token');
        if($at){
            return $at;
            exit;
        }else{
            $appid = config('wechat.app_id');
            $appsecret = config('wechat.app_secret');

            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $res = http_curl($url,'get','array');
            
            $at = $res['access_token'];
            if($at){
                cache('access_token',$at,7200);
                return $at;
            }else{
                throw new Exception('获取access_token失败');
            }
        }

        
    }

    // 获取jsapi_ticket
    public function getJsapiTicket(){
        $jsapi_ticket = cache('jsapi_ticket');
        if($jsapi_ticket){
            return $jsapi_ticket;
            exit;
        }else{
            $access_token = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=jsapi";
            $res = http_curl($url,'get','array');
            $jsapi_ticket = $res['ticket'];
            if($jsapi_ticket){
                cache('jsapi_ticket',$jsapi_ticket,7200);
                return $jsapi_ticket;
            }else{
                throw new Exception('获取jsapi_ticket失败');
            }
        }
        
    }

    // 获取随机字符串
    private function getRandStr($num=16){
        $charts = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz0123456789";
        $max = strlen($charts);
        $noncestr = "";
        for($i = 0; $i < $num; $i++)
        {
            $noncestr .= $charts[mt_rand(0, $max)];
        }
 
 
        return $noncestr;

    }

    // 返回分享接口需要的参数
    public function wxShareParams(){
        // $at = $this->getAccessToken();
        $appid = config('wechat.app_id');
        $timestamp = time();
        $nonceStr = $this->getRandStr();
        $jsapi_ticket = $this->getJsapiTicket();
        $url = 'http://192.168.1.253:8080/detail?no=0OZ72018080610210052';//当前网页

        $str = "jsapi_ticket={$jsapi_ticket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";

        $signature = sha1($str);
        return [
            'appId'=>$appid,
            'timestamp'=>$timestamp,
            'nonceStr'=>$nonceStr,
            'signature'=>$signature
        ];
    }
}