<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\TagsManager;
use App\Tag;
use App\Post;
use Carbon\Carbon;


class AndroidClientController extends Controller
{
    //
    public function getCategories(Request $request){
    	
    	$categories = TagsManager::getFirstLevelTagsNameAndId();
    	$result = array(
    			'ret' => 0,
    			'msg' => 'ok',
    	);
    	
    	$data = array('totalnum' => count($categories));
    	$info = array();
    	foreach ($categories as $category => $id){
    		$temp = array('title' => $category, 'cid' => $id);
    		$info[] = $temp;
    	}
    	$data['info'] = $info;
    	
    	$result['data'] = $data;

    	return $result;
    	
    }
    
    public function getSpecifyCategoryNews(Request $request){
    	
    	$starttid = $request->get('starttid');
    	$count = $request->get('count');
    	$cid = $request->get('cid');
    	
    	$tag = Tag::find($cid);
    	$reverse_direction = (bool)$tag->reverse_direction;
    	
    	$posts = Post::where('published_at', '<=', Carbon::now())
    	->whereHas('tags', function ($q) use ($tag) {
    		$q->where('tag', '=', $tag->tag);
    	})
    	->where('is_draft', 0)
    	->orderBy('published_at', $reverse_direction ? 'asc' : 'desc')
    	->get()  //十分重要的get函数，为啥像BlogIndexData.php里面的查询就没有用到get函数的呢？
    	->all(); //all可以将对象变数组 
    	
    	$partPosts = array_slice($posts, $starttid, $count); //分页
    	
    	$newsList = array();
    	foreach ($partPosts as $v){
    		
    		$temp = array();
    		$temp['commentcount'] = 1;
    		$temp['nid'] = $v->id;
    		$temp['digest'] = $v->subtitle;
    		$temp['source'] = 'Me CZH Blog';
    		$temp['title'] = $v->title;
    		$temp['ptime'] = $v->published_at->format('F j, Y');
    		
    		$newsList[] = $temp;	
    	}
    	
    	
    	 
    	//$posts->addQuery('tag', $tag->tag);
    	
    	
    	return [
    	'ret' => 0,		
    	'msg' => 'ok',
    	'data' => array('totalnum' => count($partPosts), 'newslist' => $newsList),
    	];
    }

    public function getNews(Request $request){
    	$nid = $request->get('nid');
    	
    	$result = array(
    			'ret' => 0, 
    			'msg' => 'ok'
    	);
    	
    	$news = array();
    	$post = Post::find($nid);
    	
    	$news['nid'] = $nid;
    	$news['source'] = 'Me CZH Blog';
    	$news['title'] = $post->title;
    	$news['body'] = $post->content_html;
    	$news['ptime'] = $post->published_at->format('F j, Y');
    	$news['replaycount'] = 10;
    	
    	$result['data']['news'] = $news;
    	return $result;
    	   	
    }
}
