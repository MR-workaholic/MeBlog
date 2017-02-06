<?php

use App\Services\Markdowner;

class MarkdownerTest extends TestCase
{

	protected $markdown;

	public function setup()
	{
		$this->markdown = new Markdowner();
	}

	public function testSimpleParagraph()
	{
		$this->assertEquals(
				"<p>test</p>\n",
				$this->markdown->toHTML('test')
		);
	}
	
// 	新的测试代码，一次过进行多次测试

	/**
	 * @dataProvider conversionsProvider
	 */
	
	public function testConversions($value, $expected)
	{
		$this->assertEquals($expected, $this->markdown->toHTML($value));
	}
	
	public function conversionsProvider()
	{
		return [
		["test", "<p>test</p>\n"],
		["# title", "<h1>title</h1>\n"],
		["Here's Johnny!", "<p>Here&#8217;s Johnny!</p>\n"],
		];
	}
	
}