<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Carbon\Carbon;

class PostCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	        'title' => 'required',
	        'subtitle' => 'required',
	        'content' => 'required',
	        'publish_date' => 'required',
	        'publish_time' => 'required',
	        'layout' => 'required',
        ];
    }
    
    /**
     * Return the fields and values to create a new post from
     * 
     * 使用postFillData方法可以轻松从请求中获取数据填充 Post 模型,注意了，需要在Post.php中声明protected $fillable数组
     */
    public function postFillData()
    {
    	$published_at = new Carbon(
    			$this->publish_date.' '.$this->publish_time
    	);
    	return [
	    	'title' => $this->title,
	    	'subtitle' => $this->subtitle,
	    	'page_image' => $this->page_image,
	    	'content_html' => $this->get('content'),
	    	'meta_description' => $this->meta_description,
	    	'is_draft' => (bool)$this->is_draft,
	    	'published_at' => $published_at,
	    	'layout' => $this->layout,
    	];
    }
    
}
