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
Route::post('bargian_api/createbargain', 'wx_bargain_api/Bargain/createBargain')
->allowCrossDomain();
/* ->header('Access-Control-Allow-Origin','*')
->header('Access-Control-Allow-Headers','Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With,Access-Token')
// ->header('Access-Control-Expose-Headers','*')
->allowCrossDomain(); */
// 帮助砍价
Route::post('bargian_api/dobargain', 'wx_bargain_api/Bargain/doBargain')
->allowCrossDomain();

//我的砍价单
Route::get('bargian_api/bargainorders', 'wx_bargain_api/Bargain/getBargainOrder')
->allowCrossDomain();

// 获取砍价订单详情
Route::get('bargian_api/bargaindetail', 'wx_bargain_api/Bargain/getDetail')
->allowCrossDomain();

// 返回微信分享需要的参数
Route::get('bargian_api/wxshare', 'wx_bargain_api/Wx/wxShare')
->allowCrossDomain();

// 后台统计AdminStatistics
Route::get('bargian_api/admin', 'wx_bargain_api/AdminStatistics/getOrders')
->allowCrossDomain();