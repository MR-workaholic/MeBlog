<?php
namespace App\Services;

use App\Tag;

class TagsManager
{
	public static function getFirstLevelTags()
	{
		return Tag::where('level', '=', '0')->orderBy('show_order')->lists('tag')->all();
	}
	
	public static function getSecondLevelTags($firstLevelTags)
	{
		$secondLevelTags = array();
		foreach ($firstLevelTags as $tag)
		{
			$secondLevelTags[$tag] = Tag::where('belog_to', '=', $tag)->lists('tag')->all();
		}
		return $secondLevelTags;
	}
	
	public static function getFirstLevelTagsIcons($firstLevelTags)
	{
		$firstLevelTagsIcons = array();
		foreach ($firstLevelTags as $tag)
		{
			$firstLevelTagsIcons[$tag] = Tag::where('tag', '=', $tag)->lists('icon')->first();
			// or Tag::whereTag($tag)->first()->icon;
		}
		return $firstLevelTagsIcons;
	}
	
	public static function checkShowOrderUnique($showOrder)
	{
		if (Tag::where('show_order', '=', $showOrder)->exists()){
			return false;
		}
		return true;
	}
}