<?php namespace Ecom\App\Controllers;

use Ecom\System\MVC;

class Random
{
	public function index()
	{
		$product_model = new \Ecom\App\Models\Product();
		$items = $product_model->getProducts(['type' => 'random']);
		$content = new MVC\View('search.php', ['items' => $items]);
		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'random']);
		$views->render();
	}

}