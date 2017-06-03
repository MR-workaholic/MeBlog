<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AndroidComment extends Model
{
    //
    
	protected $fillable = [
	'post_id',
	'region',
	'content',
	];
	/**
	 * 获取拥有此评论的日志。
	 */
	public function post(){
		return $this->belongsTo(Post::class);
	}    
}
