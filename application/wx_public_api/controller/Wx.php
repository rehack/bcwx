<?php
namespace app\wx_public_api\controller;
use app\wx_public_api\service\Wx as WxService;
use app\wx_public_api\service\wxBizDataCrypt;
use think\facade\Request;
use think\Db;
use think\Exception;

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

    // 获取session_key和openid和unionid
    private function sessionkeyopenid($appid,$app_secret,$code){
        $api = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
        $url = sprintf($api,$appid,$app_secret,$code);
        $wxResult = http_curl($url,'get','array');
        return $wxResult;
    }
    // 获取手机号
    public function getPhoneNumber(){
        $data = Request::param();
        $iv = $data['iv'];
        $res = $this->sessionkeyopenid($data['appid'],$data['appsecret'],$data['code']);
        
        // 开始解密手机号
        $aesKey=base64_decode($res['session_key']);
		if (strlen($iv) != 24) {
			throw new Exception('iv无效'); 
		}
		$aesIV=base64_decode($iv);
		$aesCipher=base64_decode($data['encryptedData']);
		$result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        // halt($result);
		$dataObj=json_decode( $result ,true);
        $this->savePhoneNumber($dataObj);
        return json($dataObj);
        
    }

    // 将手机号存入数据库
    private function savePhoneNumber($data){
        $bcdb_config =[
            // 数据库类型
            'type'        => 'mysql',
            // 服务器地址
            'hostname'    => '120.76.101.135',
            // 数据库名
            'database'    => 'wap_cdbcck_com',
            // 数据库用户名
            'username'    => 'system',
            // 数据库密码
            'password'    => 'OzxqGfy*tJTFhyz8',
            // 数据库编码默认采用utf8
            'charset'     => 'utf8',
            // 数据库表前缀
            'prefix'      => 'dede_',
        ];
        // $c = Db::connect($bcdb_config);
        $d = [
            'phonenumber'=>$data['phoneNumber'],
            'purephonenumber'=>$data['purePhoneNumber'],
            'countrycode'=>$data['countryCode'],
            'create_time'=>date("Y-m-d H:i:s")
        ];
        Db::connect($bcdb_config)->table('dede_diyform23')->insert($d);
        // return $c->table('dede_diyform23')->find();
    }
    
}