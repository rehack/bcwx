<?php
namespace app\wx_bargain_api\validate;

class Bargain extends BaseValidate{
    protected $rule=[
        'goods_id'=>'require|isNotEmpty|isPositiveInteger',
        
    ];

    protected $message=[
        'goods_id'=>'商品id不正确'
    ];
    

}
