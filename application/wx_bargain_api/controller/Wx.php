<?php
namespace app\wx_bargain_api\controller;
use app\wx_bargain_api\service\Wx as WxService;


class Wx{
    /* public function getjt(){
        // $wx = new WxService();
        // $jt =$wx->getJsapiTicket();
        $c = cache('access_token');
        $d = cache('jsapi_ticket');
        return $c;
    } */

    // 返回微信分享需要的参数
    public function wxShare(){
        $currentUrl = input('get.currentUrl');
        // $currentUrl = 'http%3A%2F%2F192.168.1.253%3A8080%2Fdetail%3Fno%3D62TT2018080697554854';
        // return $currentUrl;exit;
        $wx = new WxService();
        // $data = $wx->wxShareParams($currentUrl);
        $data = $wx->wxShareParams($currentUrl);
        return json_encode($data,true);
    }
}