<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MerchandiseTag;

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

	/**
	 * Sync tag relation adding new tags as needed
	 *
	 * @param array $tags
	 */
	public function syncTags(array $tags)  //为merchandise加标签的函数
	{
		
		// 将文章与标签对应一起
		if (count($tags)) {
			// 任何不在给定数组中的IDs将会从中介表中被删除
			$this->merchandisetags()->sync(
					MerchandiseTag::whereIn('tag', $tags)->lists('id')->all()
			);
			return;
		}
		//无标签则 用detach删除所有对应关系
		$this->merchandisetags()->detach();
	}



}
