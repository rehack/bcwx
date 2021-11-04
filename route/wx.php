<?php
// 获取token
Route::get('wx_api/gettoken', 'wx_public_api/Token/getToken')
->allowCrossDomain();
// 获取小程序授权手机号
Route::get('wxapi/getphonenumber', 'wx_public_api/Wx/getPhoneNumber')
->allowCrossDomain();