<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = [
		'tag', 
		'title', 
		'subtitle',
		'level',
		'belog_to',
		'show_order',
		'page_image',
		'icon', 
		'meta_description',
		'reverse_direction',
	];
	
	/**
	 * 定义文章与标签之间多对多关联关系
	 *
	 * @return BelongsToMany
	 */
	public function posts()
	{
		return $this->belongsToMany('App\Post', 'post_tag_pivot');
	}
	
	/**
	 * Set the belog_to attribute 
	 * 
	 * @param int $value
	 */
	public function setBelogToAttribute($value)
	{
		
		if ($this->attributes['level'] == 1)
		{
			$this->attributes['belog_to'] = $value;
		}else{
			$this->attributes['belog_to'] = '';
		}	 
	}
	
	/**
	 * Set the show_order attribute
	 *
	 * @param int $value
	 */
	public function setShowOrderAttribute($value)
	{
	
		if ($this->attributes['level'] == 1)
		{
			$this->attributes['show_order'] = 0;
		}else{
			$this->attributes['show_order'] = $value;
		}
	}
	
	
	
	
	/**
	 * Add any tags needed from the list
	 *
	 * @param array $tags List of tags to check/add
	 */
	public static function addNeededTags(array $tags)
	{
		if (count($tags) === 0) {
			return;
		}
	
		$found = static::whereIn('tag', $tags)->lists('tag')->all();
		
		//  如果有新的标签则创建出来
		foreach (array_diff($tags, $found) as $tag) {
			static::create([
					'tag' => $tag,
					'title' => $tag,
					'subtitle' => 'Subtitle for '.$tag,
					'level' => 1,
					'belog_to' => 'other',
					'page_image' => '',
					'meta_description' => '',
					'reverse_direction' => false,
					]);
		}
	}
	
	/**
	 * Return the index layout to use for a tag
	 *
	 * @param string $tag
	 * @param string $default
	 * @return string
	 */
	public static function layout($tag, $default = 'blog.layouts.index')
	{
		$layout = static::whereTag($tag)->pluck('layout');
	
		return $layout ?: $default;
	}
	
}
