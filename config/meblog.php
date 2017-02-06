<?php
return [
	'name' => 'CZH的博客',
	'title' => 'Me CZH Blog',
	'subtitle' => 'My Beautiful Blog (meblog.app/blog)',
	'posts_per_page' => 5,
	'uploads' => [
		'storage' => 'local',  //定义使用的文件系统
		'webpath' => '/uploads',  //定义文件访问的根目录
	],
	'page_image' => '/uploads/default.jpg',
	'description' => ' all tags`description ',
	'author' => 'CZH',
	'contact_email' => '13580518842@163.com',
	'youdao' => [
		'api_key' => '1784704438',
		'key_from' => 'MeBlogapp111',
	],
	'rss_size' => 25,
];