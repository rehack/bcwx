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
        $wx = new WxService();
        $data = $wx->wxShareParams();
        return json_encode($data,true);
    }
}