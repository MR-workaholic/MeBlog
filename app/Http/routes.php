<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
//     return view('welcome');
	return redirect('/blog');
});

Route::get('blog', 'BlogController@index');
Route::get('blog/{slug}', 'BlogController@showPost');

//联系我路由
Route::get('contact', 'ContactController@showForm');
Route::post('contact', 'ContactController@sendContactInfo');

// rss路由
Route::get('rss', 'BlogController@rss');

//站点地图
Route::get('sitemap.xml', 'BlogController@siteMap');


// Admin area
Route::get('admin', function (){
	return redirect('admin/post');
});

Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function (){  //中间件的作用是只有验证通过的用户才能访问该路由
	//  两个RESTful资源路由 
	Route::resource('admin/post', 'PostController', ['except' => 'show']);  //由于命名空间是Admin，故对应的路由已经是Http/Controller/Admin下面的路由了
	Route::resource('admin/tag', 'TagController', ['except' => 'show']);
	
	Route::get('admin/upload', 'UploadController@index');
	Route::post('admin/upload/file', 'UploadController@uploadFile');
	Route::delete('admin/upload/file', 'UploadController@deleteFile');
	Route::post('admin/upload/folder', 'UploadController@createFolder');
    Route::delete('admin/upload/folder', 'UploadController@deleteFolder');

    Route::resource('admin/merchandisetag', 'MerchandiseTagController', ['except' => 'show']);
    Route::resource('admin/merchandises', 'MerchandiseController', ['except' => 'show']);

});

// Logging in and out
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

// Setting Message
Route::get('/setting', 'SettingController@index');
Route::post('/setting/userinfo', 'SettingController@modifyUserInfo');
Route::post('/setting/passwordinfo', 'SettingController@modifyPassword');

// wechat
Route::get('/wechat', 'WechatController@authentication'); //微信认证
Route::post('/wechat', 'WechatController@handlemMessage'); //接收用户信息
Route::get('/wechat/menu', 'WechatController@menu'); //接收用户信息

//安卓client
Route::get('androidblog/getCategories', 'AndroidClientController@getCategories');
Route::get('androidblog/getSpecifyCategoryNews', 'AndroidClientController@getSpecifyCategoryNews');
Route::get('androidblog/getNews', 'AndroidClientController@getNews');
Route::get('androidblog/getComments', 'AndroidClientController@getComments');
Route::post('androidblog/postComment', 'AndroidClientController@postComment');

// 商品展示
Route::get('/merchandise', 'MerchandiseController@index');
