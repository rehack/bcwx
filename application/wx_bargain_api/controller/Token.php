<?php
namespace app\wx_bargain_api\controller;

use \think\Controller;
use app\wx_bargain_api\service\UserToken;

class Token extends Controller{
    // 用户同意授权，获取code，微信授权引导页面
    public function login(){
        $appid = config('wechat.app_id');        
        $host = config('setting.host');
        $redirect_uri=urlencode("{$host}/wx_bargain_api/Token/callback");

        $scope='snsapi_userinfo';

        // 获取code
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=STATE#wechat_redirect";//接口地址
        // echo $url;
        // header('location',$url);

        // 重定向
        $this->redirect($url,302);
    }

    // 此接口是微信授权页面的回调地址，获取微信服务器通过get方式传递来的code参数
    public function callback(){
        $code = input('get.code');//code只能使用一次，5分钟未被使用自动过期 每次用户授权带上的code将不一样
        
        // 拿到code交给UserToken层去处理（获取access_token和openid->获取用户详细信息->生成token令牌）
        $ut = new UserToken($code);
        $token = $ut->returnToken();

        // 生成token后返回给客户端
        return json([
            'token'=>$token
        ]);
    }
}