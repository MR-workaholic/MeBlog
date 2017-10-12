<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\MerchandiseTag;

class MerchandiseTagController extends Controller
{

  protected $fields = [
    'tag' => '在页面上显示的标签',
    'title' => '标签的标注',
  ];

  protected $rules = [
    'title' => 'required'
  ];

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $merchandisetags = MerchandiseTag::all();
    return view('admin.merchandisetag.index', ['merchandisetags' => $merchandisetags]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    $data = [];
    foreach ($this->fields as $field => $default) {
      $data[$field] = old($field, $default);
    }
    $data['method'] = 'create';
    return view('admin.merchandisetag.create', $data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
    $data = $request->all();
    $store_rules = array_merge(array('tag' => 'required|unique:merchandise_tags,tag'), $this->rules);
    $validator = Validator::make($data, $store_rules);
    if($validator->fails()){
      return back()->withErrors($validator);
    }
    $merchandisetag = new MerchandiseTag();
    foreach(array_keys($this->fields) as $field){
      $merchandisetag->$field = $request->get($field);
    }
    $merchandisetag->save();

    return redirect('/admin/merchandisetag')->withSuccess("The tag '$merchandisetag->tag' was created");
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
    $merchandisetag = MerchandiseTag::findOrFail($id);
    $data['id'] = $id;
    foreach(array_keys($this->fields) as $field)
    {
      $data[$field] = $merchandisetag->$field;
    }
    $data['method'] = 'edit';
    /*     return $data;*/
    return view('admin.merchandisetag.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
    $merchandisetag = MerchandiseTag::findOrFail($id);
    $data = $request->all();
    $validator = Validator::make($data, $this->rules);

    $tagNew = $data['tag'];
    $tagOld = $merchandisetag->tag;
    $validator->after(function($validator) use ($tagNew, $tagOld){
      if($tagNew != $tagOld){
        $tags = MerchandiseTag::where('tag', '!=', $tagOld)->lists('tag')->all();
        if(in_array($tagNew, $tags)){
          $validator->errors()->add('tag', "we already have tag:".$tagNew);
        }
      }
    });

    if($validator->fails()){
      return back()->withErrors($validator);
    }

    foreach(array_keys($this->fields) as $field){
      $merchandisetag->$field = $request->get($field);
    }
    $merchandisetag->save();

    return redirect("admin/merchandisetag/$id/edit")->withSuccess("Change saved.");

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
    $merchandisetag = MerchandiseTag::findOrFail($id);
    /* 清除标签商品关系对应表 */
    $merchandisetag->merchandises()->detach();
    $merchandisetag->delete();

    return redirect('/admin/merchandisetag')->withSuccess("The tag has been deleted");
  }
}
