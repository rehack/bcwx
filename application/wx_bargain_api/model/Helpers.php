<?php
namespace app\wx_bargain_api\model;
use think\Model;

class Helpers extends Model{
    protected $autoWriteTimestamp = true;
    // 关闭自动写入update_time字段
    protected $updateTime = false;
    
    // 关联usersinfo表
    public function user(){
        return $this->belongsTo('UsersInfo','helper_id');
    }
}