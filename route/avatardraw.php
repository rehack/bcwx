<?php
// 获取token
Route::get('avatardraw/customer', 'avatar_draw_api/Customer/getAllCustomer')
->allowCrossDomain();
// 更新中奖人员
Route::post('avatardraw/updatelucky', 'avatar_draw_api/Customer/updateLucky')
->allowCrossDomain();