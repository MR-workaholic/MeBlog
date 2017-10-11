<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchandiseTag extends Model
{
    //
    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;
    protected $fillable = ['tag', 'title'];

    /**
     * 定义了商品与标签之间的多对多关系
     *
     **/
    public function merchandises()
    {
        return $this->belongsToMany('App\Merchandise', 'merchandise_merchandise_tag_pivot');
    }

}
