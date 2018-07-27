<?php
namespace app\wx_bargain_api\validate;

class AddUser extends BaseValidate{
    protected $rule=[
        'openid'=>'require|unique:users_info',
        'nickname'=>'require',
        'sex'=>'require',
        'city'=>'require',
        'province'=>'require',
        'country'=>'require',
        'headimgurl'=>'require',
    ];

    protected $message=[
        'openid.unique'=>'openid已经存在'
    ];
    

}
