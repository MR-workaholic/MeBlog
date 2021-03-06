<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Post;
use App\Tag;
use Carbon\Carbon;

class PostFormFields extends Job implements SelfHandling
{
	
	/**
	 * The id (if any) of the Post row
	 *
	 * @var integer
	 */
	protected $id;
	
	/**
	 * List of fields and default value for each field
	 *
	 * @var array
	 */
	protected $fieldList = [
		'title' => '',
		'subtitle' => '',
		'page_image' => '',
		'content' => '',
		'meta_description' => '',
		'is_draft' => "0",
		'publish_date' => '',
		'publish_time' => '',
		'layout' => 'blog.layouts.post',
		'tags' => [],
	];
	
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id = NULL)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	$fields = $this->fieldList;
    	
    	if ($this->id) {
    		$fields = $this->fieldsFromModel($this->id, $fields);
    	} else {
    		$when = Carbon::now()->addHour();
    		$fields['publish_date'] = $when->format('M-j-Y');
    		$fields['publish_time'] = $when->format('g:i A');
    	}
    	
    	foreach ($fields as $fieldName => $fieldValue) {
    		$fields[$fieldName] = old($fieldName, $fieldValue);
    	}
    	
    	return array_merge(
    			$fields,
    			['allTags' => Tag::lists('tag')->all()]
    	);
    }
    
    /**
     * Return the field values from the model
     *
     * @param integer $id
     * @param array $fields
     * @return array
     */
    protected function fieldsFromModel($id, array $fields)
    {
    	$post = Post::findOrFail($id);
    
    	$fieldNames = array_keys(array_except($fields, ['tags']));
    
    	$fields = ['id' => $id];
    	// 你会发现content，publish_date与publish_time是没有的，其实在Post.php中提供了相应的函数
    	// 如：getContentAttribute
    	foreach ($fieldNames as $field) {
    		$fields[$field] = $post->{$field};
    	}
    
    	$fields['tags'] = $post->tags()->lists('tag')->all();
    
    	return $fields;
    }
    
    
    
    
    
}
