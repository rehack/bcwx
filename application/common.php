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