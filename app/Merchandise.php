<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    //
    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['src', 'alt'];

    public function merchandisetags()
    {
        return $this->belongsToMany('App\MerchandiseTag', 'merchandise_merchandise_tag_pivot');
    }


}
