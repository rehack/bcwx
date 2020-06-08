<?php
// 获取token
Route::get('wx_api/gettoken', 'wx_public_api/Token/getToken')
->allowCrossDomain();