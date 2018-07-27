<?php
namespace app\wx_bargain_api\controller;

use \think\Controller;
use app\wx_bargain_api\model\UsersInfo as UsersInfoModel;
use app\wx_bargain_api\validate\AddUser;
use app\lib\exception\UserException;

class Index extends Controller
{
    public function index()
    {
        return 'wxapi';
    }


    // 用户同意授权，获取code
    public function getUserCode(){
        // 判断用户是否登录过
        $openid = session('openid');
        if($openid){
            $userInfo = UsersInfoModel::where('openid',$openid)->select();
            $this->assign('data',$userInfo);
            return $this->fetch();
            // return $userInfo;
        }
        // echo 1;exit;
        $appid = config('wechat.app_id');
        
        $redirect_uri=urlencode("http://192.168.1.253/wx_bargain_api/index/getUserDetail");
        // echo $app_secret;
        $scope='snsapi_userinfo';
        // 获取code
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$scope&state=STATE#wechat_redirect";//接口地址
        // echo $url;
        // header('location',$url);

        // 重定向
        $this->redirect($url,302);
    }

    // 获取用户详细信息
    public function getUserDetail(){
        // echo 1;exit;
        $appid = config('wechat.app_id');
        $app_secret = config('wechat.app_secret');
        $code = input('get.code');//code只能使用一次，5分钟未被使用自动过期 每次用户授权带上的code将不一样

        // echo $code;exit;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$app_secret&code=$code&grant_type=authorization_code";
        // echo $url;exit;
        // 获取用户openid
        $res = $this->http_curl($url,'get','array');

        // dump($res);
        $access_token=$res['access_token'];
        $openid=$res['openid'];

        // 根据access_token和openid获取用户详细信息
        $url="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";

        $detail = $this->http_curl($url,'get','array');
        // dump($detail);
        $validate = new AddUser();
        if (!$validate->check($detail)) {
            session('openid',$detail['openid']);
            throw new UserException([
                'msg'=>$validate->getError(),
                'errorCode'=>60000
            ]);
        }
        $userInfo = UsersInfoModel::create($detail);
        $openid = $userInfo->openid;
        session('openid',$openid);
        return $userInfo;
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
