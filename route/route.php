<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


Route::get('bargian_api/gettoken', 'wx_bargain_api/Token/getToken')
->header('Access-Control-Allow-Origin','*')
->allowCrossDomain();
/* ->header('Access-Control-Allow-Origin','http://192.168.1.253:8080')
->header('Access-Control-Allow-Credentials', 'true')
->allowCrossDomain(); */

