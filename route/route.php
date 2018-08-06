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

/* Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

return [

]; */

// 获取token
Route::get('bargian_api/gettoken', 'wx_bargain_api/Token/getToken')
// ->header('Access-Control-Allow-Origin','*')
->allowCrossDomain();
/* ->header('Access-Control-Allow-Origin','http://192.168.1.253:8080')
->header('Access-Control-Allow-Credentials', 'true')
->allowCrossDomain(); */

// 获取所有商品
Route::get('bargian_api/goods', 'wx_bargain_api/Goods/getGoods')
// ->header('Access-Control-Allow-Origin','*')
->allowCrossDomain();

// 发起砍价
Route::get('bargian_api/createbargain', 'wx_bargain_api/Bargain/createBargain')
/* ->header('Access-Control-Allow-Origin','*')
->header('Access-Control-Allow-Headers','Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With,Access-Token')
// ->header('Access-Control-Expose-Headers','*') */
->allowCrossDomain();