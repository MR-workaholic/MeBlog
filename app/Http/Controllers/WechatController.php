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
		
// 获取SDK服务方式三 在 config/app.php 中 alias 部分添加外观别名：'EasyWeChat' => Overtrue\LaravelWechat\Facade::class,
// 		$wechatServer = EasyWeChat::server(); // 服务端
// 		$wechatUser = EasyWeChat::user(); // 用户服务
	}
	
	
	
	public function handlemessage()
	{
		Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
	
		$wechat = app('wechat');  //获取SDK服务的方式一
		$wechat->server->setMessageHandler(function($message) use ($wechat){
			$userService = $wechat->user;
			$user = $userService->get($openId);
			return $user->nickname.",欢迎您关注【树多多事多】！";
		});
	
		Log::info('return response.');
	
		return $wechat->server->serve();
	}
}
