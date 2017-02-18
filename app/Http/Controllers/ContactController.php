<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMeRequest;
use Illuminate\Support\Facades\Mail;
use App\Services\TagsManager;

class ContactController extends Controller
{
	/**
	 * 显示表单
	 *
	 * @return View
	 */
	public function showForm()
	{
		$firstleveltags = TagsManager::getFirstLevelTags();
		$secondleveltags = TagsManager::getSecondLevelTags($firstleveltags);
		$firstleveltagsicons = TagsManager::getFirstLevelTagsIcons($firstleveltags);
		
		$data['first_level_tags'] = $firstleveltags;
		$data['second_level_tags'] = $secondleveltags;
		$data['first_level_tags_icons'] = $firstleveltagsicons;
		return view('blog.contact', $data);
	}
	
	/**
	 * Email the contact request
	 *
	 * @param ContactMeRequest $request
	 * @return Redirect
	 */
	public function sendContactInfo(ContactMeRequest $request)
	{
		$data = $request->only('name', 'email', 'phone');
		$data['messageLines'] = explode("\n", $request->get('message'));
	
		// 用什么queue方法取决于.env的queue_driver了
		Mail::queue('emails.contact', $data, function ($message) use ($data) {
			$message->subject('Blog Contact Form: '.$data['name'])
			->to(config('meblog.contact_email'))
			->replyTo($data['email']);
		});
	
		return back()
			->withSuccess("Thank you for your message. It has been sent.");
	}
}
