<?php
namespace app\wx_public_api\controller;
use app\wx_public_api\service\Wx as WxService;
use app\wx_public_api\service\wxBizDataCrypt;
use think\facade\Request;

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

    // 获取session_key和openid
    private function sessionkeyopenid($appid,$app_secret,$code){
        $api = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
        $url = sprintf($api,$appid,$app_secret,$code);
        $wxResult = http_curl($url,'get','array');
        return $wxResult;
    }
    public function getPhoneNumber(){
        $data = Request::param();
        halt($data);
        $this->sessionkeyopenid($data['appsecret']);
        $pc = new wxBizDataCrypt;
    }
}