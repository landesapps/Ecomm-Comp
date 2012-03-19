<?php namespace Ecom\App\Controllers;

use Ecom\System\MVC;

class Assets
{
	public function index($name)
	{
		$asset = new MVC\Asset();
		$view = $asset->render($name);
	}
}