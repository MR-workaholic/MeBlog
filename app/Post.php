<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Markdowner;
use Carbon\Carbon;
use JellyBool\Translug\Translug;
use App\Tag;

class Post extends Model
{
    
	protected $dates = ['published_at'];
	protected $fillable = [
		'title', 
		'subtitle', 
		'content_html', 
		'page_image', 
		'meta_description',
		'layout', 
		'is_draft', 
		'published_at',
	];
	
	
// 	public function setTitleAttribute($value)
// 	{
// 		$this->attributes['title'] = $value;
	
// 		if (! $this->exists) {
// 			$this->attributes['slug'] = str_slug($value);
// 		}
// 	}
	
	public function tags()
	{
		return $this->belongsToMany('App\Tag', 'post_tag_pivot');
	}
	
	/**
	 * Set the title attribute and automatically the slug 若title字段被设置则自动调用该函数
	 *
	 * @param string $value
	 */
	public function setTitleAttribute($value)
	{		
 		if (! $this->exists || ($this->exists && $this->attributes['title'] != $value)) {
			$translug = new Translug(['keyfrom'=>config('meblog.youdao.key_from'), 'key'=>config('meblog.youdao.api_key')]);			
			$this->setUniqueSlug($value, $translug);
 		}
 		$this->attributes['title'] = $value;
	}
	
	/**
	 * Recursive routine to set a unique slug
	 *
	 * @param string $title
	 * @param Translug $translug
	 */
	protected function setUniqueSlug($title, $translug)
	{
		$slug = $translug->translug($title);
		$slug = $slug.'-'.rand(0, 100);
	
		if (static::whereSlug($slug)->exists()) {
			$this->setUniqueSlug($title, $translug);
			return;
		}
	
		$this->attributes['slug'] = $slug;
	}
	
	/**
	 * Set the HTML content automatically when the raw content is set 若contentraw字段被设置则字段调用该函数
	 * 
	 * @param string $value
	 */
	public function setContentHtmlAttribute($value)
	{
		$markdown = new Markdowner();
	
// 		$this->attributes['content_raw'] = $value;
		$this->attributes['content_html'] = $markdown->toHTML($value);
	}
	
	/**
	 * Sync tag relation adding new tags as needed
	 *
	 * @param array $tags
	 */
	public function syncTags(array $tags)  //为文章加标签的函数
	{
		Tag::addNeededTags($tags);  //  如果有新的标签则创建出来
		
		// 将文章与标签对应一起
		if (count($tags)) {
			$addTags = array();
			foreach ($tags as $tag)
			{
				$checkTag = Tag::whereTag($tag)->first();
				if ($checkTag->level == 1 && !in_array($checkTag->belog_to, $tags))
				{
					array_push($addTags, $checkTag->belog_to);
				}
			}
			if (count($addTags))
			{
				$tags = array_merge($tags, $addTags);
			}
			// 任何不在给定数组中的IDs将会从中介表中被删除
			$this->tags()->sync(
					Tag::whereIn('tag', $tags)->lists('id')->all()
			);
			return;
		}
		//无标签则 用detach删除所有对应关系
		$this->tags()->detach();
	}
	
	/**
	 * Return the date portion of published_at
	 */
	public function getPublishDateAttribute($value)
	{
		return $this->published_at->format('M-j-Y');
	}
	
	/**
	 * Return the time portion of published_at
	 */
	public function getPublishTimeAttribute($value)
	{
		return $this->published_at->format('g:i A');
	}
	
	/**
	 * Alias for content_raw
	 */
	public function getContentAttribute($value)
	{
		return $this->content_html;
	}
	
	/**
	 * Return URL to post
	 *
	 * @param Tag $tag
	 * @return string
	 */
	public function url(Tag $tag = null) //在blog.layouts.index/post中都使用
	{
		$url = url('blog/'.$this->slug);
		if ($tag) {
			$url .= '?tag='.urlencode($tag->tag);
		}
	
		return $url;
	}
	
	/**
	 * Return array of tag links
	 *
	 * @param string $base
	 * @return array
	 */
	public function tagLinks($base = '/blog?tag=%TAG%')  //在blog.layouts.index/post中都使用
	{
		$tags = $this->tags()->lists('tag');
		$return = [];
		foreach ($tags as $tag) {
			$url = str_replace('%TAG%', urlencode($tag), $base);
			$return[] = '<a href="'.$url.'">'.e($tag).'</a>';
		}
		return $return;
	}
	
	/**
	 * Return next post after this one or null
	 *
	 * @param Tag $tag
	 * @return Post
	 */
	public function newerPost(Tag $tag = null)  //在blog.layouts.post中使用
	{
		//获取一连串上一篇文章
		$query =
		static::where('published_at', '>', $this->published_at)
		->where('published_at', '<=', Carbon::now())
		->where('is_draft', 0)
		->orderBy('published_at', 'asc');
		
		//如果有tag的限定，则获取一连串上一遍文章中的tag相等的那些文章
		if ($tag) {
			$query = $query->whereHas('tags', function ($q) use ($tag) {
				$q->where('tag', '=', $tag->tag);
			});
		}
	
		return $query->first();
	}
	
	/**
	 * Return older post before this one or null
	 *
	 * @param Tag $tag
	 * @return Post
	 */
	public function olderPost(Tag $tag = null)
	{
		//获取一连串下一篇文章
		$query =
		static::where('published_at', '<', $this->published_at)
		->where('is_draft', 0)
		->orderBy('published_at', 'desc');
		
		//如果有tag的限定，则获取一连串下一遍文章中的tag相等的那些文章
		if ($tag) {
			$query = $query->whereHas('tags', function ($q) use ($tag) {
				$q->where('tag', '=', $tag->tag);
			});
		}
	
		return $query->first();
	}
	
	
}
