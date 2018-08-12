<?php
namespace app\wx_bargain_api\model;
use think\Model;

// 发起的砍价表模型
class BargainOrder extends Model{
    protected $autoWriteTimestamp = true;
    // 关闭自动写入update_time字段
    protected $updateTime = false;

    protected $type = [
        'over_time'  =>  'timestamp:Y/m/d',
    ];

    // 获取器 定义该砍价单结束时间
    public function getOverTimeAttr($value,$data)
    {   
        // config('setting.bargain_time')
        $over_time_s = strtotime("+5 day",$data['create_time']);
        $over_time = date("Y-m-d H:i:s",$over_time_s);
        return $over_time;
    }

    public function goods(){
        return $this->belongsTo('Goods','goods_id');
    }

    public function usersInfo(){
        return $this->belongsTo('UsersInfo','uid');
    }

    public function helpers(){
        return $this->hasMany('Helpers','order_id');
    }
    
}