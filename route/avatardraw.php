<?php
// 获取token
Route::get('avatardraw/customer', 'avatar_draw_api/Customer/getAllCustomer')
->allowCrossDomain();