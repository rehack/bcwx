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


Route::get('bargian_api/login', 'wx_bargain_api/index/getUserCode')
->header('Access-Control-Allow-Origin','http://192.168.3.2:8080')
->header('Access-Control-Allow-Credentials', 'true')
->allowCrossDomain();

