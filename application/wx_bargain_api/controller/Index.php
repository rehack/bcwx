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


    // 用户同意授权，获取code，微信授权引导页面
    public function getUserCode(){
        // echo 1;exit;
        $appid = config('wechat.app_id');        
        $redirect_uri=urlencode("http://192.168.3.2/wx_bargain_api/index/getUserDetail");

        $scope='snsapi_userinfo';

        // 获取code
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=STATE#wechat_redirect";//接口地址
        // echo $url;
        // header('location',$url);

        // 重定向
        $this->redirect($url,302);
    }

    // 获取用户详细信息，此页面是微信授权页面的回调地址
    public function getUserDetail(){
        // echo 1;exit;
        $appid = config('wechat.app_id');
        $app_secret = config('wechat.app_secret');
        $code = input('get.code');//code只能使用一次，5分钟未被使用自动过期 每次用户授权带上的code将不一样

        // echo $code;exit;
        // 通过code获取access_token和openid
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$app_secret}&code={$code}&grant_type=authorization_code";
        // echo $url;exit;
        $res = $this->http_curl($url,'get','array');
        // dump($res);exit;
        $access_token=$res['access_token'];
        // 缓存
        // S('access_token',$token,3600);
        $openid=$res['openid'];
        if(!$openid){
            $this->error('授权失败，稍后请重试!');
        }

        // 根据用户openid查看用户在数据库是否存在
        $user = UsersInfoModel::where('openid',$openid)->find();
        // 存在则直接登陆
        if($user){
            session('openid',$openid);
            return '已经有openid';
        }

        // 根据access_token和openid获取用户详细信息
        $url="https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";

        $detail = $this->http_curl($url,'get','array');
        // dump($detail);exit;
        $validate = new AddUser();
        if (!$validate->check($detail)) {
            // session('openid',$detail['openid']);
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
