<?php
namespace app\wx_bargain_api\model;
use think\Model;

class Goods extends Model{

    // 关联图片表
    public function images()
    {
        return $this->belongsTo('Images','img_id');
    }

    public static function getDetailById($id){
        $goods = self::find($id);
        return $goods;
    }
}