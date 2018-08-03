<?php
namespace app\wx_bargain_api\validate;

class TokenGet extends BaseValidate{
    protected $rule=[
        'code'=>'require|isNotEmpty',
        
    ];

    protected $message=[
        'code'=>'非法操作，code参数不存在'
    ];
    

}
