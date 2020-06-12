<?php
// 获取抽奖项目
Route::get('avatardraw/luckyitem', 'avatar_draw_api/Customer/getLuckyItem')
->allowCrossDomain();
// 设置参与者的轮次
Route::post('avatardraw/setlun', 'avatar_draw_api/Customer/setLun')
->allowCrossDomain();
// 获取参与者
Route::get('avatardraw/customer', 'avatar_draw_api/Customer/getAllCustomer')
->allowCrossDomain();
// 更新中奖人员
Route::post('avatardraw/updatelucky', 'avatar_draw_api/Customer/updateLucky')
->allowCrossDomain();
// 初始化数据
Route::post('avatardraw/init', 'avatar_draw_api/Customer/initData')
->allowCrossDomain();
// 查询自己是否中奖
Route::get('avatardraw/isprize', 'avatar_draw_api/Customer/isPrize')
->allowCrossDomain();
