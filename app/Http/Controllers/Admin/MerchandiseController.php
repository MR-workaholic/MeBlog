<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Merchandise;
use App\MerchandiseTag;
use App\Jobs\MerchandiseData;
use Illuminate\Support\Facades\Validator;


class MerchandiseController extends Controller
{

  protected $fields = [
    'src' => '图片名',
    'alt' => '图片介绍',
  ];

  protected $rules = [
    'src' => 'required',
    'tags' => 'required',
  ];

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $merchandises = $this->dispatch(new MerchandiseData());
    
    /*     return $merchandises;*/
    return view('admin.merchandise.index', ['merchandises' => $merchandises]);
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
    foreach(array_keys($this->fields) as $field){
      $data[$field] = $this->fields[$field];
    }
    $data['method'] = 'create';
    $data['allTags'] = MerchandiseTag::lists('tag')->all();
    $data['tags'] = [];
    /*     return $data;*/
    return view('admin.merchandise.create', $data);
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
    /*     $store_rules = array_merge(array('src' => 'required|unique:merchandises,src'), $this->rules);*/
    $validator = Validator::make($data, $this->rules);
    if($validator->fails()){
      return back()->withErrors($validator);
    }
    $merchandise = new Merchandise();
    foreach(array_keys($this->fields) as $field){
      $merchandise->$field = $request->get($field);
    }
    $merchandise->save();

    $merchandise->syncTags($request->get('tags', []));

    return redirect('/admin/merchandises')->withSuccess("The new merchandise was created");

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
    $merchandise = Merchandise::findOrFail($id);
    $data['id'] = $id;
    foreach(array_keys($this->fields) as $field){
      $data[$field] = $merchandise->$field;
    }
    $data['method'] = 'edit';
    $data['allTags'] = MerchandiseTag::lists('tag')->all();
    $data['tags'] = $merchandise->merchandisetags()->lists('tag')->all();
    /*     return $data;*/
    return view('admin.merchandise.edit', $data);

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
    //规则：src必须但不是独一无二，可以共享同一个图片
    $data = $request->all();
    $validator = Validator::make($data, $this->rules);
    if($validator->fails())
    {
      return back()->withErrors($validator);
    }
    $merchandise = Merchandise::findOrFail($id);
    foreach(array_keys($this->fields) as $field){
      $merchandise->$field = $request->get($field);
    }
    $merchandise->save();
    $merchandise->syncTags($request->get('tags', []));
    return redirect("admin/merchandises/$id/edit")->withSuccess("Change saved");
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
    $merchandise = Merchandise::findOrFail($id);
    /* 清除标签商品关系对应表 */
    $merchandise->merchandisetags()->detach();
    $merchandise->delete();

    return redirect('/admin/merchandises')->withSuccess("The merchandise has been deleted");
  }
}
