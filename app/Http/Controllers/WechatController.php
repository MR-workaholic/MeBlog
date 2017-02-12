<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message;
use EasyWeChat;
use Illuminate\Support\Facades\Redirect;

class WechatController extends Controller
{
	
	protected $buttons = [
		[
			"name" => "我的博客",
			"sub_button" => [
				[
					"type" => "click",
					"name" => "博客首页",
					"key"  => "menu_1_1"
				],
				[
					"type" => "click",
					"name" => "管理员后台",
					"key"  => "menu_1_2"
				],
			],
		],
		[
			"name" => "网站链接",
			"sub_button" => [
				[
					"type" => "view",
					"name" => "搜索",
					"url"  => "https://www.baidu.com/"
				],
				[
					"type" => "view",
					"name" => "博客首页",
					"url"  => "http://119.29.171.68/blog"
				],
				[
					"type" => "view",
					"name" => "中关村",
					"url"  => "http://www.zol.com.cn/"
				],
			],
		],
		[
			"name" => "新增类型按钮",
			"sub_button" => [
				[
					"type" => "pic_sysphoto",
					"name" => "系统拍照发图",
					"key"  => "menu_3_1",
					"sub_button" => [],
				],
				[
					"type" => "pic_photo_or_album",
					"name" => "拍照或者相册发图",
					"key"  => "menu_3_2",
					"sub_button" => [],
				],
				[
					"type" => "pic_weixin",
					"name" => "微信相册发图",
					"key"  => "menu_3_3",
					"sub_button" => [],
				],
				[
					"type" => "scancode_waitmsg",
					"name" => "扫码带提示",
					"key"  => "menu_3_4",
					"sub_button" => [],
				],
				[
					"type" => "location_select",
					"name" => "发送位置",
					"key"  => "menu_3_5",
				],
			],
		],
	];
	
// 	获取SDK服务方式二，依赖注入 前面加上use EasyWeChat\Foundation\Application; 参数写上Application $wechat
	public function authentication(Application $wechat)
	{
		Log::info("start serve authentication");
		$response = $wechat->server->serve();
		Log::info("return authentication response");
		return $response;
	}
	
	
	
	public function handlemMessage()
	{
		Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
	
		$wechat = app('wechat');  //获取SDK服务的方式一
		$server = $wechat->server;
		$server->setMessageHandler(function($message) use ($wechat){
			$openId = $message->FromUserName; // 用户的 openid	
			$msgType = $message->MsgType;		
//			api unauthorized hint出现这个错误是微信没有授权，现在没有获取用户信息的权限，故使用下面的语句会出错
// 			$user = $wechat->user->get($openId);

			switch ($msgType)
			{
				case 'text':
// 					$msgResponse = "你发送的消息是:[".$message->Content."]";
					//方式一：
					$msgResponse = new Message\Text(['content' => "你发送的消息是:[".$message->Content."]你的ID是[".$openId."]"]);
					break;
				case 'image':
// 					$msgResponse = "你发送的图片是:[".$message->PicUrl."]";
                    //方式二：
					$msgResponse = new Message\Image();
					$msgResponse->media_id = $message->MediaId;
					break;
				case 'voice':
					$msgResponse = "你发送的语音id是:[".$message->MediaId."]以及格式是：[".$message->Format."]";
					//方式二：
					$msgResponse = new Message\Voice();
					$msgResponse->media_id = $message->MediaId;
					break;
				case 'video':
					$msgResponse = "你发送的视频id是:[".$message->MediaId."]以及缩略图媒体id是：[".$message->ThumbMediaId."]";
					//方式三：
// 					$msgResponse = new Message\Video();
// 					$msgResponse->setAttribute('title', '给回你的视频');
// 					$msgResponse->setAttribute('description', '这是你的视频，现在给回你的视频');
// 					$msgResponse->setAttribute('media_id', $message->MediaId);
// 					$msgResponse->setAttribute('thumb_media_id', $message->ThumbMediaId);
					break;
				case 'shortvideo':
					$msgResponse = "你发送的小视频id是:[".$message->MediaId."]以及缩略图媒体id是：[".$message->ThumbMediaId."]";
					break;
				case 'location':
					$msgResponse = "你发送的地理位置纬度是:[".$message->Location_X."]以及地理位置经度是：[".$message->Location_Y."]以及地理位置信息是[".$message->Label.']';
					break;
				case 'location':
					$msgResponse = "你发送的地理位置纬度是:[".$message->Location_X."]以及地理位置经度是：[".$message->Location_Y."]以及地理位置信息是[".$message->Label.']';
					break;
				case 'link':
					$msgResponse = "你发送的消息标题是:[".$message->Title."]以及消息描述是：[".$message->Description."]以及消息链接是[".$message->Url.']';
					break;
				case 'event':
					if ($message->Event == 'subscribe')
					{
						$msgResponse = "欢迎关注树多多事多，这里有很多东西等待你去开发";	
					}else {
						$message = null;
					}
					break;
				default: 
					$msgResponse = null;
					break;
			}
			Log::info('make response.');
			return $msgResponse;
		});
	
		Log::info('return response.');
	
		return $server->serve();
	}
	
	public function menu()
	{
		// 获取SDK服务方式三 在 config/app.php 中 alias 部分添加外观别名：'EasyWeChat' => Overtrue\LaravelWechat\Facade::class,
		// 		$wechatServer = EasyWeChat::server(); // 服务端
		// 		$wechatUser = EasyWeChat::user(); // 用户服务
		$menu = EasyWeChat::menu();
		Log::info("start add menu");
		$menu->add($this->buttons);  //没有权限，api unauthorized hint
		return Redirect::back()->withMessage('菜单设置成功！');
		
	}
}
