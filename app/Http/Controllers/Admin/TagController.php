<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;

// 在TagController顶部添加这个use语句
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
	
	protected $fields = [
		'tag' => '',
		'title' => '',
		'subtitle' => '',
		'level' => 1,
		'belog_to' => 'other',
		'meta_description' => '',
		'page_image' => '',
		'layout' => 'blog.layouts.index',
		'reverse_direction' => 0,
	];
	
	protected $rules = [
		'title'    => 'required',
		'subtitle' => 'required',
		'level'    => 'required',
		'layout'   => 'required',
	];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$tags = Tag::all();
    	return view('admin.tag.index')->withTags($tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$data = [];
    	foreach ($this->fields as $field => $default) {
    		$data[$field] = old($field, $default);
    	}
    	$data['allFirstLevelTags'] = Tag::where('level', '=', 0)->lists('tag')->all();
    	
    	return view('admin.tag.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //注意这里由Request改为 TagCreateRequest，这也是依赖注入的一种
//     public function store(TagCreateRequest $request)
	public function store(Request $request)  
    {
    	$data = $request->all();
    	$store_rules = array_merge(array('tag' => 'required|unique:tags,tag'), $this->rules);
    	$validator = Validator::make($data, $store_rules);
    	
    	$level = $request->get('level');
    	$belog_to = $request->get('belog_to');
    	$validator->after(function($validator) use ($level, $belog_to) {
    		if ($level == 1 && $belog_to == "") { // 若设置为二级目录，必须有一个对应的一级目录
    			$validator->errors()->add('belog_to', 'Select a first-level tag if this is a second-level tag'); //错误的话显示错误信息
    		}
    	});
    	if ($validator->fails()) {      //判断是否有错误
    		return back()->withErrors($validator);  //重定向页面，并把错误信息存入一次性session里
    	}
    	
    	$tag = new Tag();
    	foreach (array_keys($this->fields) as $field) {
    		$tag->$field = $request->get($field);
    	}
    	$tag->save();
    	
    	return redirect('/admin/tag')
    	->withSuccess("The tag '$tag->tag' was created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//     public function show($id)
//     {
//         //
//     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$tag = Tag::findOrFail($id);
    	$data = ['id' => $id];  //将ID拼接上去
    	foreach (array_keys($this->fields) as $field) {
    		$data[$field] = old($field, $tag->$field);
    	}
    	$data['allFirstLevelTags'] = Tag::where('level', '=', 0)->lists('tag')->all();
    	
    	return view('admin.tag.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//     public function update(TagUpdateRequest $request, $id)
    public function update(Request $request, $id)
    {
    	$tag = Tag::findOrFail($id);
    	
    	$data = $request->all();
    	$validator = Validator::make($data, $this->rules);
    	 
    	$level = $request->get('level');
    	$belog_to = $request->get('belog_to');
    	$validator->after(function($validator) use ($level, $belog_to, $tag) {
    		if ($level == 1 && $belog_to == "") { // 若设置为二级目录，必须有一个对应的一级目录
    			$validator->errors()->add('belog_to', 'Select a first-level tag if this is a second-level tag'); //错误的话显示错误信息
    		}
    		
    		if ($level == 1 && $tag->level == 0 && Tag::where('belog_to', '=', $tag->tag)->exists()){
    			$validator->errors()->add('belog_to', "A non empty first-level tag can't change to a second-level tag"); //错误的话显示错误信息
    		}
    	});
    	if ($validator->fails()) {      //判断是否有错误
    		return back()->withErrors($validator);  //重定向页面，并把错误信息存入一次性session里
    	}
    	  	
    	foreach (array_keys(array_except($this->fields, ['tag'])) as $field) {
    		$tag->$field = $request->get($field);
    	}
    	$tag->save();
    	
    	return redirect("/admin/tag/$id/edit")
    	->withSuccess("Changes saved.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$tag = Tag::findOrFail($id);
    	$tag->delete();
    	
    	return redirect('/admin/tag')
    	->withSuccess("The '$tag->tag' tag has been deleted.");
    }
}
