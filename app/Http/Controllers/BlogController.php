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

class BlogController extends Controller
{
	public function index(Request $request)
	{
		$tag = $request->get('tag');
		$data = $this->dispatch(new BlogIndexData($tag));
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
		$post = Post::with('tags')->whereSlug($slug)->firstOrFail();
		$tag = $request->get('tag');
		if ($tag) {
			$tag = Tag::whereTag($tag)->firstOrFail();
		}
		
		return view($post->layout, compact('post', 'tag', 'slug'));
		
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
