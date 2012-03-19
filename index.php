<?php

require_once 'Ecom/System/Autoload/Load.php';

$uri = explode('/', substr($_SERVER['REQUEST_URI'], 1));

$autoload = new Ecom\System\Autoload\Load();

$autoload->setPaths([
	'Ecom\\System' => __DIR__.'/Ecom/System',
	'Ecom\\App'    => __DIR__.'/Ecom/App'
]);

$autoload->register();

$session = new Ecom\System\Session\Session();

$router = new Ecom\System\Router\Route();

$router->add('any', '/home:any', function($data = null, $post = null)
{
	$data = trim($data, '/');
	$data = explode('/', $data);
	$data[] = $post;

	route('Home', array_shift($data), $data);
});

$router->add('any', '/manga:any', function($data = null, $post = null)
{
	$data = trim($data, '/');
	$data = explode('/', $data);
	$data[] = $post;

	route('Manga', array_shift($data), $data);
});

$router->add('any', '/anime:any', function($data = null, $post = null)
{
	$data = trim($data, '/');
	$data = explode('/', $data);
	$data[] = $post;

	route('Anime', array_shift($data), $data);
});

$router->add('any', '/random:any', function($data = null, $post = null)
{
	$data = trim($data, '/');
	$data = explode('/', $data);
	$data[] = $post;

	route('Random', array_shift($data), $data);
});

$router->add('any', '/account:any', function($data = null, $post = null)
{
	$data = trim($data, '/');
	$data = explode('/', $data);
	$data[] = $post;

	route('Account', array_shift($data), $data);
});

$router->add('any', '/product:any', function($data = null, $post = null)
{
	$data = trim($data, '/');
	$data = explode('/', $data);
	$data[] = $post;

	route('Product', array_shift($data), $data);
});

$router->add('any', '/assets:any', function($data = null)
{
	$data = trim($data, '/');
	$data = explode('/', $data);

	route('Assets', array_shift($data), [implode('/', $data)]);
});

$router->add('any', '/cart:any', function($data = null, $post = null)
{
	$data = trim($data, '/');
	$data = explode('/', $data);
	$data[] = $post;

	route('Cart', array_shift($data), $data);
});

$router->add('any', '', 'Ecom\\App\\Controllers\\Home\\index');
$router->add('any', ':any', 'Ecom\\App\\Controllers\\Home\\index');

$uri = explode('?', $_SERVER['REQUEST_URI']);

$router->dispatch($uri[0]);

function route($controller, $method, $params)
{
	if(empty($method))
	{
		$method = 'index';
	}

	call_user_func_array(array('Ecom\\App\\Controllers\\'.$controller, $method), $params);
}