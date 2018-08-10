<?php
namespace app\wx_bargain_api\model;
use think\Model;

class Helpers extends Model{
    protected $autoWriteTimestamp = true;
    // 关闭自动写入update_time字段
    protected $updateTime = false;
    
}