<?php namespace Ecom\App\Controllers;

use Ecom\System\MVC;

class Anime
{
	public function index()
	{
		$product_model = new \Ecom\App\Models\Product();
		$items = $product_model->getProductsByCategory('anime');

		$content = new MVC\View('search.php', ['items' => $items]);
		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'anime']);
		$views->render();
	}

}