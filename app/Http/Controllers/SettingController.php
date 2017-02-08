<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
	protected $fields = [
		'name' => '',
		'email' => '',
	];
	
    public function __construct()
    {
    	$this->middleware('auth');
    }
    
    public function index(Request $request)
    {
//     	$name = $request->user()->name;
//     	$email = $request->user()->email;
    	
    	$data = [];
    	foreach (array_keys($this->fields) as $field)
    	{
    		$data[$field] = old($field, $request->user()->$field);
    	}
    	
    	return view('setting.index', $data);
    	
    }
    
    public function modifyUserInfo(UserInfoRequest $request)
    {
    	$user = Auth::user();
    	foreach (array_keys($this->fields) as $field)
    	{
    		$user->$field = $request->get($field);
    	}
    	$user->save();
    	return back()->withSuccess("The user information have been modified.");
    }
    
    public function modifyPassword(Request $request)
    {
    	$data = $request->all();
    	
    	$rules = [
	    	'oldpassword'=>'required|between:6,20',
	    	'newpassword'=>'required|between:6,20|confirmed',
    	];
//     	使用confirmed的话是为了新密码和确认密码进行相同判断，确认密码必须的name值
// 		必须是新密码的name值后面加上’_confirmation’

    	$messages = [
	    	'required' => '密码不能为空',
	    	'between' => '密码必须是6~20位之间',
	    	'confirmed' => '新密码和确认密码不匹配'
    	];
    	
    	$validator = Validator::make($data, $rules, $messages);
    	
    	$user = Auth::user();
    	$oldpassword = $request->input('oldpassword');
    	$newpassword = $request->input('newpassword');
    	
    	$validator->after(function($validator) use ($oldpassword, $user) {
    		if (!\Hash::check($oldpassword, $user->password)) { //原始密码和数据库里的密码进行比对
    			$validator->errors()->add('oldpassword', '原密码错误'); //错误的话显示原始密码错误
    		}
    	});
    	if ($validator->fails()) {      //判断是否有错误
    		return back()->withErrors($validator);  //重定向页面，并把错误信息存入一次性session里
    	}
    	$user->password = bcrypt($newpassword);       //使用bcrypt函数进行新密码加密
    	$user->save();      //成功后，保存新密码
    	Auth::logout();  //更改完这次密码后，退出这个用户
    	return redirect('/auth/login');
    }
    
}
