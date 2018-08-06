<?php
namespace app\wx_bargain_api\model;
use think\Model;

// 发起的砍价表模型
class BargainOrder extends Model{
    protected $autoWriteTimestamp = true;
    // 关闭自动写入update_time字段
    protected $updateTime = false;
    
}