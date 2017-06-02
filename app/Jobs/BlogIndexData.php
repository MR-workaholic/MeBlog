<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Post;
use App\Tag;
use Carbon\Carbon;

class BlogIndexData extends Job implements SelfHandling
{
	protected $tag;
	
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	if ($this->tag) {
    		return $this->tagIndexData($this->tag);
    	}
    	
    	return $this->normalIndexData();
    }
    
    /**
     * Return data for normal index page
     *
     * @return array
     */
    protected function normalIndexData()
    {
    	$posts = Post::with('tags')
    	->where('published_at', '<=', Carbon::now())
    	->where('is_draft', 0)
    	->orderBy('published_at', 'desc')
    	->simplePaginate(config('blog.posts_per_page'));
    
    	return [
	    	'title' => config('meblog.title'),
	    	'subtitle' => config('meblog.subtitle'),
	    	'posts' => $posts,
	    	'page_image' => config('meblog.page_image'),
	    	'meta_description' => config('meblog.description'),
	    	'reverse_direction' => false,
	    	'tag' => null,
    	];
    }
    
    /**
     * Return data for a tag index page
     *
     * @param string $tag
     * @return array
     */
    protected function tagIndexData($tag)
    {
    	$tag = Tag::where('tag', $tag)->firstOrFail();
    	$reverse_direction = (bool)$tag->reverse_direction;
    
    	$posts = Post::where('published_at', '<=', Carbon::now())
    	->whereHas('tags', function ($q) use ($tag) {
    		$q->where('tag', '=', $tag->tag);	//见Post.php的L36
    	})
    	->where('is_draft', 0)
    	->orderBy('published_at', $reverse_direction ? 'asc' : 'desc')
    	->simplePaginate(config('meblog.posts_per_page'));	//分页使用，供前端的分页模块使用，如blog.layouts.index
    	
    	$posts->addQuery('tag', $tag->tag);
    
    	$page_image = $tag->page_image ?: config('meblog.page_image');
    
    	return [
	    	'title' => $tag->title,		//虽然现在的title先登记的是tag的，但在blog.layouts.post会转为文章的title
	    	'subtitle' => $tag->subtitle,
	    	'posts' => $posts,        //posts是一个ORM对象，而不是数组??
	    	'page_image' => $page_image,
	    	'tag' => $tag,
	    	'reverse_direction' => $reverse_direction,
	    	'meta_description' => $tag->meta_description ?: config('meblog.description'),
    	];
    }
}
