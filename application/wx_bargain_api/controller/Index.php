<?php
namespace app\wx_bargain_api\controller;

use \think\Controller;
use app\wx_bargain_api\model\UsersInfo as UsersInfoModel;
use app\wx_bargain_api\validate\AddUser;
use app\lib\exception\UserException;
use think\facade\Env;

class Index extends Controller{
    public function __construct(){
        parent::__construct();
        // echo Env::get('runtime_path').'session/';

        // 初始化session
        session([
            'path' => Env::get('runtime_path').'session/',
            // 'expire' => 3600*24*1,//过期时间1天
            'expire' => 20,
        ]);
    }


    public function index()
    {
        return 'index';
    }


    // 用户同意授权，获取code
    public function getUserCode(){
        // echo 3;exit;
        
        // session('test','eeee');
        // return session('test');
        // exit;
        if(session('openid')){
            // return session('openid');
            // exit;
            // 显示商品列表
            $user = $this->getUserByOpenId(session('openid'));
            // $user = $user->toArray();
            $this->assign('user', [$user,'ss'=>1]);
            return $this->fetch('goodslist');
            exit;
        }
        // echo 1;
        $appid = config('wechat.app_id');
        $domain = config('wechat.domain');
        $redirect_uri=urlencode("{$domain}/wx_bargain_api/index/getUserDetail");

        $scope='snsapi_userinfo';

        // 获取code
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=STATE#wechat_redirect";//接口地址
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
        if(!$code){
            return '网络错误，请稍后重试！';
        }

        // echo $code;exit;
        // 通过code获取access_token和openid
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$app_secret}&code={$code}&grant_type=authorization_code";
        // echo $url;exit;
        $res = $this->http_curl($url,'get','array');
        // dump($res);exit;
        if(isset($res['errcode'])){
            return '网络错误';
            exit;
        }
        $access_token=$res['access_token'];
        $openid=$res['openid'];
        if(!$openid){
            $this->error('授权失败，稍后请重试!');
        }

        // 根据用户openid查看用户在数据库是否存在
        $user = $this->getUserByOpenId($openid);
        // $user=$user->toArray();
        // 存在则直接登陆
        if($user){
            session('openid',$openid);
            // 显示商品列表
            // dump($user);exit;
            $this->assign('user', $user);
            return $this->fetch('goodslist');
            exit;
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
        $user = UsersInfoModel::create($detail);
        $user = $user->toArray();
        // $openid = $user->openid;
        session('openid',$openid);
        // return $user;
        // 显示商品列表
        $this->assign('user', $user);
        return $this->fetch('goodslist');
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

    // 通过openid获取用户信息
    private function getUserByOpenId($openid){
        $user = UsersInfoModel::where('openid',$openid)->find();
        return $user;
    }
}
