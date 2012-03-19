<?php namespace Ecom\System\MVC;

use Ecom\System\Configuration;

class Asset
{
	public function render($name)
	{
		$configs = new Configuration\Configurator();

		$assets = $configs->assets;
		$name = trim($name, '/');

		ob_start();

		switch(strtolower(substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '.')+1)))
		{
			case 'css':
				header('Content-Type: text/css');
				break;
			case 'js':
				header('Content-Type: text/javascript');
				break;
			case 'jpeg':
			case 'jpg':
				header('Content-Type: image/jpeg');
				break;
			case 'gif':
				header('Content-Type: image/gif');
				break;
			case 'png':
				header('Content-Type: image/png');
				break;
			default:
				header('Content-Type: text/plain');
		}

		echo file_get_contents($assets['location'].'/'.$name);

		ob_flush();
	}
}