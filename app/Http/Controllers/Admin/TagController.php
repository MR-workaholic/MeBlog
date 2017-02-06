<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;

// 在TagController顶部添加这个use语句
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;

class TagController extends Controller
{
	
	protected $fields = [
		'tag' => '',
		'title' => '',
		'subtitle' => '',
		'meta_description' => '',
		'page_image' => '',
		'layout' => 'blog.layouts.index',
		'reverse_direction' => 0,
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
    	
    	return view('admin.tag.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\TagCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    //注意这里由Request改为 TagCreateRequest，这也是依赖注入的一种
    public function store(TagCreateRequest $request)  
    {
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
    	
    	return view('admin.tag.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\TagUpdateRequest   $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, $id)
    {
    	$tag = Tag::findOrFail($id);
    	
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
