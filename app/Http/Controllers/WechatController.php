<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller
{
// 	获取SDK服务方式二，依赖注入 前面加上use EasyWeChat\Foundation\Application; 参数写上Application $wechat
	public function authentication(Application $wechat)
	{
		Log::info("start serve authentication");
		$response = $wechat->server->serve();
		Log::info("return authentication response");
		return $response;
	}
	
	public function handlemessage()
	{
		Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
	
		$wechat = app('wechat');  //获取服务的方式一
		$wechat->server->setMessageHandler(function($message){
			return "欢迎关注  树多多事多！";
		});
	
		Log::info('return response.');
	
		return $wechat->server->serve();
	}
}
