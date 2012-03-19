<?php namespace Ecom\App\Controllers;

use Ecom\System\MVC;
use Ecom\App\Models;

class Product
{
	public function index($product, $postData = null)
	{
		$product_model = new Models\Product();
		$results = $product_model->getProductsByIds([$product])[0];
		$content = new MVC\View('product.php', $results);
		$views = new MVC\View('template.php', ['content' => $content, 'selected' => 'home']);
		$views->render();
	}

}