<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
// curl封装
function http_curl($url,$type='get',$resType='json',$arr=''){
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
// 生成随机字符串
function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;
    for ($i = 0;$i < $length;$i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}
function fromArrayToModel($m , $array)
{
    foreach ($array as $key => $value)
    {
        $m[$key] = $value;
    }
    return $m;
}


// 生成唯一订单编号
function create_order_id()
{
    /* $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    // return $orderSn; */

    $num = 4;
    $re = '';
    $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    while (strlen($re) < $num) {
        $re .= $s[rand(0, strlen($s) - 1)]; // 从$s中随机产生一个字符
    }

    return $re.date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}


// 产生指定返回内的随机小数
function randomFloat($min, $max) {
    $n = $min + mt_rand() / mt_getrandmax() * ($max - $min);
    $num = round($n,2);
    return $num;
}

