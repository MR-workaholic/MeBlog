<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use Carbon\Carbon;
use App\Jobs\BlogIndexData;
use App\Tag;
use App\Services\RssFeed;
use App\Services\SiteMap;
use App\Services\TagsManager;

class BlogController extends Controller
{
	public function index(Request $request)
	{
		$tag = $request->get('tag');
		$data = $this->dispatch(new BlogIndexData($tag));
		$firstleveltags = TagsManager::getFirstLevelTags();
		$secondleveltags = TagsManager::getSecondLevelTags($firstleveltags);
		$firstleveltagsicons = TagsManager::getFirstLevelTagsIcons($firstleveltags);
		$data['first_level_tags'] = $firstleveltags;
		$data['second_level_tags'] = $secondleveltags;
		$data['first_level_tags_icons'] = $firstleveltagsicons;
		
		$layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';
		return view($layout, $data);
		
// 		//  old method
// 		$posts = Post::where('published_at', '<=', Carbon::now())
// 		->orderBy('published_at', 'desc')
// 		->paginate(config('meblog.posts_per_page'));
	
// 		return view('blog.index', ['posts' => $posts])
// 		return view('blog.index', compact('posts'));
	}
	
	public function showPost($slug, Request $request)
	{
		// with('tags') 是把文章相关联的tags取出来
		$post = Post::with('tags')->whereSlug($slug)->firstOrFail();
		//在文章展示页点击上（下）一篇文章的话，request变量里面会有tag，这个特制的url是从post.php的url函数中制订出来的
		$tag = $request->get('tag');
		if ($tag) {
			$tag = Tag::whereTag($tag)->firstOrFail();
		}
		$first_level_tags = TagsManager::getFirstLevelTags();
		$second_level_tags = TagsManager::getSecondLevelTags($first_level_tags);
		$first_level_tags_icons = TagsManager::getFirstLevelTagsIcons($first_level_tags);
		
		return view($post->layout, compact('post', 'tag', 'slug', 'first_level_tags', 'second_level_tags', 'first_level_tags_icons'));
		
		// old method
// 		$post = Post::whereSlug($slug)->firstOrFail();
// 		return view('blog.post')->withPost($post);
	}
	
	public function rss(RssFeed $feed)
	{
		$rss = $feed->getRSS();
	
		return response($rss)
		->header('Content-type', 'application/rss+xml');
	}
	
	public function siteMap(SiteMap $siteMap)
	{
		$map = $siteMap->getSiteMap();
		
		return response($map)
		->header('Content-type', 'text/xml');
	}
}
